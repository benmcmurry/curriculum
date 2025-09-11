<?php
// index.php
// Minimal uploader + parser for CSV or .RIS records with RIS-style fields.
// Uses PDO + prepared statements + transaction. Basic server-side validation.
// IMPORTANT: Update DB credentials in CONFIG below.

declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

// ---------------------- CONFIG ----------------------
const DB_HOST = '127.0.0.1';
const DB_NAME = 'ELC_Curriculum';
const DB_USER = 'curriculum';
const DB_PASS = '8521curriculum';
const MAX_UPLOAD_BYTES = 10 * 1024 * 1024; // 10 MB
$ALLOWED_EXTENSIONS = ['csv', 'ris'];
$ALLOWED_MIME = [
    'text/plain',
    'text/csv',
    'application/octet-stream',
    'application/vnd.ms-excel',
];
// ----------------------------------------------------

function db(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function hasBOM(string $str): bool {
    return strncmp($str, "\xEF\xBB\xBF", 3) === 0;
}

function stripBOM(string $str): string {
    return hasBOM($str) ? substr($str, 3) : $str;
}

// Detect if file content looks like RIS (presence of TY  - and ER  - tags)
function looks_like_ris(string $path): bool {
    $fh = fopen($path, 'r');
    if (!$fh) return false;
    $count = 0;
    $ty = $er = 0;
    while (!feof($fh) && $count < 200) {
        $line = fgets($fh);
        if ($line === false) break;
        $line = trim($line);
        if (preg_match('/^TY\s*-\s*/', $line)) $ty++;
        if (preg_match('/^ER\s*-\s*/', $line)) $er++;
        $count++;
    }
    fclose($fh);
    return $ty > 0 && $er > 0;
}

// Parse .RIS file into array of associative arrays keyed by RIS tags.
function parse_ris_file(string $path): array {
    $fh = fopen($path, 'r');
    if (!$fh) throw new RuntimeException('Cannot open file');

    $records = [];
    $current = [];

    while (($line = fgets($fh)) !== false) {
        $line = rtrim($line, "\r\n");
        if ($line === '') continue;

        // Match "XX  - value" where XX is two letters or alphanumeric RIS tag
        if (preg_match('/^([A-Z0-9]{2})\s*-\s*(.*)$/u', $line, $m)) {
            $tag = $m[1];
            $val = trim($m[2]);

            if ($tag === 'TY') {
                // Start of new record
                if (!empty($current)) {
                    $records[] = $current;
                }
                $current = [];
            }

            if (!isset($current[$tag])) $current[$tag] = [];
            $current[$tag][] = $val;

            if ($tag === 'ER') {
                // End of record
                $records[] = $current;
                $current = [];
            }
        } else {
            // Continuation line: append to last tag if exists
            if (!empty($current)) {
                $lastTag = array_key_last($current);
                if ($lastTag) {
                    $lastIdx = count($current[$lastTag]) - 1;
                    $current[$lastTag][$lastIdx] .= ' ' . trim($line);
                }
            }
        }
    }
    fclose($fh);

    // In case file didn't end with ER
    if (!empty($current)) $records[] = $current;

    return $records;
}

// Parse CSV with RIS-like headers into array of RIS-tag arrays.
// Header names normalized to upper RIS tags where possible (e.g., TI, AU, PY, JO, DO, UR, AB, KW, etc.)
function parse_csv_ris(string $path): array {
    $fh = fopen($path, 'r');
    if (!$fh) throw new RuntimeException('Cannot open CSV');

    $first = fgets($fh);
    if ($first === false) return [];
    $first = stripBOM($first);
    // Rewind to process first line by CSV engine
    fclose($fh);

    $csv = new SplFileObject($path);
    $csv->setFlags(SplFileObject::READ_CSV | SplFileObject::SKIP_EMPTY | SplFileObject::DROP_NEW_LINE);
    $csv->setCsvControl(',');

    $headers = [];
    $records = [];
    foreach ($csv as $i => $row) {
        if ($row === [null] || $row === false) continue;
        // Normalize row length
        $row = array_map(static fn($v) => $v === null ? '' : trim((string)$v), $row);

        if ($i === 0) {
            $headers = array_map('normalize_header_to_ris', $row);
            continue;
        }
        if (count(array_filter($row, fn($v) => $v !== '')) === 0) continue; // skip empty

        $rec = [];
        foreach ($row as $idx => $val) {
            $tag = $headers[$idx] ?? null;
            if (!$tag || $val === '') continue;

            // Split multi-value fields (authors, keywords) on common delimiters
            if (in_array($tag, ['AU', 'KW'], true)) {
                $parts = preg_split('/\s*;\s*|\s*\|\s*|\s*,\s*(?=[^,]*,)/', $val);
                foreach ($parts as $p) {
                    $p = trim($p);
                    if ($p === '') continue;
                    $rec[$tag][] = $p;
                }
            } else {
                $rec[$tag][] = $val;
            }
        }
        if (!empty($rec)) $records[] = $rec;
    }
    return $records;
}

// Map CSV header names to canonical RIS tags
function normalize_header_to_ris(string $h): string {
    $h = trim($h);
    $hu = strtoupper($h);

    // Common mappings and synonyms
    $map = [
        'TYPE' => 'TY', 'TY' => 'TY',
        'TITLE' => 'TI', 'TI' => 'TI', 'T1' => 'TI',
        'SECONDARY TITLE' => 'T2', 'T2' => 'T2',
        'TERTIARY TITLE' => 'T3', 'T3' => 'T3',
        'AUTHOR' => 'AU', 'AUTHORS' => 'AU', 'AU' => 'AU',
        'YEAR' => 'PY', 'DATE' => 'PY', 'PY' => 'PY', 'Y1' => 'PY',
        'JOURNAL' => 'JO', 'JOURNAL NAME' => 'JO', 'JF' => 'JO', 'JO' => 'JO',
        'VOLUME' => 'VL', 'VL' => 'VL',
        'ISSUE' => 'IS', 'IS' => 'IS',
        'START PAGE' => 'SP', 'SP' => 'SP',
        'END PAGE' => 'EP', 'EP' => 'EP',
        'PAGES' => 'PG', 'PG' => 'PG',
        'DOI' => 'DO', 'DO' => 'DO',
        'URL' => 'UR', 'UR' => 'UR',
        'ABSTRACT' => 'AB', 'AB' => 'AB',
        'KEYWORDS' => 'KW', 'KEYWORD' => 'KW', 'KW' => 'KW',
        'PUBLISHER' => 'PB', 'PB' => 'PB',
        'ISSN' => 'SN', 'ISBN' => 'SN', 'SN' => 'SN',
    ];
    return $map[$hu] ?? $hu; // fallback to uppercased header
}

// Normalize one RIS-tagged record into DB fields shape
function normalize_record(array $ris): array {
    $getFirst = function(array $tags, array $ris) {
        foreach ($tags as $t) {
            if (!empty($ris[$t][0])) return trim((string)$ris[$t][0]);
        }
        return null;
    };
    $getAll = function(string $tag, array $ris): array {
        return array_values(array_map('trim', $ris[$tag] ?? []));
    };

    $refType = $getFirst(['TY'], $ris);
    $title   = $getFirst(['TI','T1'], $ris);

    $authorsArr = $getAll('AU', $ris);
    $authors = !empty($authorsArr) ? implode('; ', $authorsArr) : null;

    $journal = $getFirst(['JO','JF'], $ris);

    $yearRaw = $getFirst(['PY','Y1'], $ris);
    $year = null;
    if ($yearRaw) {
        if (preg_match('/\b(\d{4})\b/', $yearRaw, $m)) $year = (int)$m[1];
    }

    $volume = $getFirst(['VL'], $ris);
    $issue  = $getFirst(['IS'], $ris);

    // Pages: prefer SP/EP; else PG
    $sp = $getFirst(['SP'], $ris);
    $ep = $getFirst(['EP'], $ris);
    $pg = $getFirst(['PG'], $ris);
    $pages = null;
    if ($sp && $ep) $pages = $sp . '-' . $ep;
    elseif ($sp) $pages = $sp;
    elseif ($pg) $pages = $pg;

    $doi = $getFirst(['DO'], $ris);
    $url = $getFirst(['UR'], $ris);
    $abstract = $getFirst(['AB'], $ris);

    $keywordsArr = $getAll('KW', $ris);
    $keywords = !empty($keywordsArr) ? implode('; ', $keywordsArr) : null;

    $publisher = $getFirst(['PB'], $ris);
    $sn = $getFirst(['SN'], $ris);

    // Capture any remaining tags as JSON for auditing
    $known = ['TY','TI','T1','T2','T3','AU','PY','Y1','JO','JF','VL','IS','SP','EP','PG','DO','UR','AB','KW','PB','SN'];
    $extra = [];
    foreach ($ris as $tag => $vals) {
        if (!in_array($tag, $known, true)) {
            $extra[$tag] = array_values($vals);
        }
    }

    return [
        'ref_type'   => $refType,
        'title'      => $title,
        'authors'    => $authors,
        'journal'    => $journal,
        'year'       => $year,
        'volume'     => $volume,
        'issue'      => $issue,
        'pages'      => $pages,
        'doi'        => $doi,
        'url'        => $url,
        'abstract'   => $abstract,
        'keywords'   => $keywords,
        'publisher'  => $publisher,
        'issn_isbn'  => $sn,
        'raw_json'   => !empty($extra) ? json_encode($extra, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) : null,
    ];
}

function insert_records(PDO $pdo, array $rows): array {
    if (empty($rows)) return ['inserted' => 0, 'skipped' => 0];

    $sql = "INSERT INTO references_ris
        (ref_type, title, authors, journal, year, volume, issue, pages, doi, url, abstract, keywords, publisher, issn_isbn, raw_json)
        VALUES
        (:ref_type, :title, :authors, :journal, :year, :volume, :issue, :pages, :doi, :url, :abstract, :keywords, :publisher, :issn_isbn, :raw_json)";

    $stmt = $pdo->prepare($sql);
    $inserted = 0; $skipped = 0;

    $pdo->beginTransaction();
    try {
        foreach ($rows as $r) {
            try {
                $stmt->execute([
                    ':ref_type'  => $r['ref_type'] ?? null,
                    ':title'     => $r['title'] ?? null,
                    ':authors'   => $r['authors'] ?? null,
                    ':journal'   => $r['journal'] ?? null,
                    ':year'      => $r['year'] ?? null,
                    ':volume'    => $r['volume'] ?? null,
                    ':issue'     => $r['issue'] ?? null,
                    ':pages'     => $r['pages'] ?? null,
                    ':doi'       => $r['doi'] ?? null,
                    ':url'       => $r['url'] ?? null,
                    ':abstract'  => $r['abstract'] ?? null,
                    ':keywords'  => $r['keywords'] ?? null,
                    ':publisher' => $r['publisher'] ?? null,
                    ':issn_isbn' => $r['issn_isbn'] ?? null,
                    ':raw_json'  => $r['raw_json'] ?? null,
                ]);
                $inserted++;
            } catch (Throwable $e) {
                // Skip bad row; you can log $e->getMessage()
                $skipped++;
            }
        }
        $pdo->commit();
    } catch (Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }

    return ['inserted' => $inserted, 'skipped' => $skipped];
}

function handle_upload(array $file, array $allowedExt, array $allowedMime): array {
    if (!isset($file['error']) || is_array($file['error'])) {
        throw new RuntimeException('Invalid upload parameters.');
    }
    switch ($file['error']) {
        case UPLOAD_ERR_OK: break;
        case UPLOAD_ERR_NO_FILE: throw new RuntimeException('No file sent.');
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE: throw new RuntimeException('Exceeded filesize limit.');
        default: throw new RuntimeException('Unknown upload error.');
    }
    if ($file['size'] > MAX_UPLOAD_BYTES) {
        throw new RuntimeException('File too large.');
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        throw new RuntimeException('Invalid file extension (allowed: .csv, .ris).');
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if ($mime && !in_array($mime, $allowedMime, true)) {
        // Allow common texty mimes, but don't hard fail: different OS yields different mimes
        // We just warn.
    }
    // Move to temp location we control
    $tmpDir = sys_get_temp_dir();
    $dest = tempnam($tmpDir, 'ris_');
    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        throw new RuntimeException('Failed to move uploaded file.');
    }
    return ['path' => $dest, 'ext' => $ext, 'orig' => $file['name']];
}

// Main handler
$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (!isset($_FILES['file'])) throw new RuntimeException('No file uploaded.');
        $u = handle_upload($_FILES['file'], $ALLOWED_EXTENSIONS, $ALLOWED_MIME);

        // Decide parser: use extension primarily, fallback to content detection
        $isRis = ($u['ext'] === 'ris') || looks_like_ris($u['path']);
        $rawRecords = $isRis ? parse_ris_file($u['path']) : parse_csv_ris($u['path']);

        // Normalize and insert
        $norm = array_map('normalize_record', $rawRecords);
        $stats = insert_records(db(), $norm);

        $result = [
            'file' => $u['orig'],
            'detected_format' => $isRis ? 'RIS' : 'CSV',
            'records_parsed' => count($rawRecords),
            'inserted' => $stats['inserted'],
            'skipped' => $stats['skipped'],
        ];

        // Clean up temp file
        @unlink($u['path']);
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>RIS/CSV Import</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; margin: 2rem; }
.container { max-width: 720px; margin: 0 auto; }
.card { border: 1px solid #ddd; border-radius: 8px; padding: 1rem 1.25rem; }
label { display: block; margin-bottom: 0.5rem; font-weight: 600; }
input[type=file] { margin-bottom: 0.75rem; }
button { padding: 0.6rem 1rem; border: 0; background: #3b82f6; color: #fff; border-radius: 6px; cursor: pointer; }
button[disabled] { background: #9ca3af; cursor: not-allowed; }
.note { color: #374151; font-size: 0.95rem; margin-top: 0.5rem; }
pre { background: #f9fafb; padding: 0.75rem; border-radius: 6px; overflow: auto; }
.error { color: #b91c1c; }
.success { color: #065f46; }
.small { color: #6b7280; font-size: 0.9rem; }
</style>
</head>
<body>
<div class="container">
  <h1>Import References (CSV or RIS)</h1>
  <div class="card">
    <form id="uploadForm" method="post" enctype="multipart/form-data">
      <label for="file">Choose a .csv or .ris file</label>
      <input type="file" id="file" name="file" accept=".csv,.ris,.txt" required>
      <div id="fileInfo" class="small"></div>
      <button id="submitBtn" type="submit" disabled>Upload and Import</button>
      <div class="note">
        Notes:
        <ul>
          <li>CSV should use headers like: TI, AU, PY, JO, DO, UR, AB, KW, etc. Common synonyms are auto-mapped.</li>
          <li>RIS uses tags like TY, AU, TI, PY, JO, VL, IS, SP, EP, DO, UR, AB, KW, PB, SN; records end with ER.</li>
        </ul>
      </div>
    </form>
  </div>

  <?php if ($error): ?>
    <p class="error">Error: <?= htmlspecialchars($error) ?></p>
  <?php elseif ($result): ?>
    <p class="success">Import complete.</p>
    <pre><?= htmlspecialchars(json_encode($result, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)) ?></pre>
  <?php endif; ?>
</div>

<script>
const fileInput = document.getElementById('file');
const info = document.getElementById('fileInfo');
const submitBtn = document.getElementById('submitBtn');

function validExt(name) {
  return /\.(csv|ris|txt)$/i.test(name);
}
function prettySize(bytes) {
  const units = ['B','KB','MB','GB'];
  let i=0, v=bytes;
  while (v >= 1024 && i < units.length-1) { v /= 1024; i++; }
  return v.toFixed(1) + ' ' + units[i];
}

fileInput.addEventListener('change', () => {
  const f = fileInput.files[0];
  if (!f) { info.textContent=''; submitBtn.disabled = true; return; }
  const ok = validExt(f.name);
  info.textContent = `${f.name} (${prettySize(f.size)})` + (ok ? '' : ' — unsupported extension');
  submitBtn.disabled = !ok;
});
</script>
</body>
</html>
