<?php
// citations.php
// Display imported references in APA format, searchable across all fields,
// and sortable by type. Includes a small JSON API for the frontend.
//
// REQUIREMENTS:
// - PHP 8+ recommended
// - MySQL table `references_ris` as defined previously
//
// IMPORTANT: Update DB credentials below.

declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

// ---------------------- CONFIG ----------------------
const DB_HOST = '127.0.0.1';
const DB_NAME = 'ELC_Curriculum';
const DB_USER = 'curriculum';
const DB_PASS = '8521curriculum';
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

// Small JSON API: GET ?action=search&q=...&sort=type_asc|type_desc
// Returns up to 2000 rows to simplify grouping client-side (no pagination here).
if (($_GET['action'] ?? '') === 'search') {
    header('Content-Type: application/json; charset=utf-8');

    $q = trim((string)($_GET['q'] ?? ''));
    $sort = (string)($_GET['sort'] ?? 'type_asc');
    $limit = 2000; // adjust as needed

    // Build WHERE for full-text-ish search across many columns
    $where = [];
    $params = [];

    if ($q !== '') {
        $terms = preg_split('/\s+/', $q) ?: [];
        $columns = [
            'ref_type','title','authors','journal','year','volume','issue','pages',
            'doi','url','abstract','keywords','publisher','issn_isbn'
        ];
        foreach ($terms as $t) {
            $t = trim($t);
            if ($t === '') continue;
            $like = '%' . $t . '%';
            $ors = [];
            foreach ($columns as $c) {
                $ors[] = "$c LIKE ?";
                $params[] = $like;
            }
            if (!empty($ors)) {
                $where[] = '(' . implode(' OR ', $ors) . ')';
            }
        }
    }
    $whereSql = '';
    if (!empty($where)) {
        $whereSql = 'WHERE ' . implode(' AND ', $where);
    }

    $order = 'ref_type ASC, year DESC, title ASC';
    if ($sort === 'type_desc') {
        $order = 'ref_type DESC, year DESC, title ASC';
    }

    $pdo = db();

    $countSql = "SELECT COUNT(*) AS cnt FROM references_ris $whereSql";
    $stmtCount = $pdo->prepare($countSql);
    $stmtCount->execute($params);
    $total = (int)$stmtCount->fetchColumn();

    $sql = "SELECT id, ref_type, title, authors, journal, year, volume, issue, pages, doi, url, abstract, keywords, publisher, issn_isbn
            FROM references_ris
            $whereSql
            ORDER BY $order
            LIMIT $limit";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    echo json_encode([
        'items' => $rows,
        'total' => $total,
        'limit' => $limit,
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>References (APA) — Grouped Tables</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
:root {
  --fg: #111827;
  --muted: #6b7280;
  --bg: #ffffff;
  --card: #f9fafb;
  --accent: #2563eb;
  --border: #e5e7eb;
}
* { box-sizing: border-box; }
body { margin: 0; background: var(--bg); color: var(--fg); font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif; }
.container { max-width: 1100px; margin: 2rem auto; padding: 0 1rem; }
h1 { margin: 0 0 1rem; font-size: 1.6rem; }
h2 { margin: 1.75rem 0 0.5rem; font-size: 1.2rem; }
.controls { display: grid; grid-template-columns: 1fr auto auto; gap: 0.75rem; align-items: center; margin-bottom: 1rem; }
input[type="search"] { width: 100%; padding: 0.6rem 0.75rem; border: 1px solid var(--border); border-radius: 8px; }
select { padding: 0.55rem 0.75rem; border: 1px solid var(--border); border-radius: 8px; background: #fff; }
button { padding: 0.55rem 0.75rem; border: 1px solid var(--border); border-radius: 8px; background: #fff; }
.summary { color: var(--muted); margin: 0.5rem 0 1rem; }
.card { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 1rem; }
.table-wrap { background: var(--card); border: 1px solid var(--border); border-radius: 8px; padding: 0.75rem; }
table { width: 100%; border-collapse: collapse; }
thead th { text-align: left; font-weight: 600; border-bottom: 1px solid var(--border); padding: 0.5rem 0.25rem; }
tbody td { border-bottom: 1px solid var(--border); padding: 0.6rem 0.25rem; vertical-align: top; }
.col-type { width: 12ch; color: var(--muted); }
.col-link { width: 3ch; text-align: center; }
.link-btn { display: inline-flex; align-items: center; justify-content: center; width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--border); background: #fff; color: var(--accent); text-decoration: none; }
.link-btn:hover { background: #eff6ff; border-color: #bfdbfe; }
.link-icon { width: 16px; height: 16px; }
.small { font-size: 0.9rem; color: var(--muted); }
.apa { list-style: none; margin: 0; padding: 0; }
@media (max-width: 720px) {
  .controls { grid-template-columns: 1fr; }
  .col-type { width: 10ch; }
  .col-link { width: 3ch; }
}
</style>
</head>
<body>
<div class="container">
  <h1>References (APA)</h1>
  <div class="controls">
    <input id="q" type="search" placeholder="Search all fields (title, author, journal, DOI, year, keywords, publisher, etc.)" aria-label="Search">
    <select id="sort" aria-label="Sort by type">
      <option value="type_asc">Sort by Type (A–Z)</option>
      <option value="type_desc">Sort by Type (Z–A)</option>
    </select>
    <button id="clearBtn" type="button" title="Clear search">Clear</button>
  </div>

  <div class="summary">
    <span id="totalCount">0</span> total results
    <span class="small" id="queryInfo"></span>
  </div>

  <section>
    <h2>Presentations <span class="small" id="countPresentations">(0)</span></h2>
    <div class="table-wrap">
      <table aria-label="Presentations">
        <thead>
          <tr>
            <th class="col-type">Type</th>
            <th>Citation (APA)</th>
            <th class="col-link" title="Link">↗</th>
          </tr>
        </thead>
        <tbody id="tbodyPresentations"></tbody>
      </table>
    </div>
  </section>

  <section>
    <h2>Projects, Theses, and Dissertations <span class="small" id="countPTD">(0)</span></h2>
    <div class="table-wrap">
      <table aria-label="Projects, Theses, and Dissertations">
        <thead>
          <tr>
            <th class="col-type">Type</th>
            <th>Citation (APA)</th>
            <th class="col-link" title="Link">↗</th>
          </tr>
        </thead>
        <tbody id="tbodyPTD"></tbody>
      </table>
    </div>
  </section>

  <section>
    <h2>Other Publications <span class="small" id="countOther">(0)</span></h2>
    <div class="table-wrap">
      <table aria-label="Other Publications">
        <thead>
          <tr>
            <th class="col-type">Type</th>
            <th>Citation (APA)</th>
            <th class="col-link" title="Link">↗</th>
          </tr>
        </thead>
        <tbody id="tbodyOther"></tbody>
      </table>
    </div>
  </section>

  <p class="small">Note: Click the icon to open the DOI or URL in a new tab. Sorting is applied by Reference Type.</p>
</div>

<script>
// ------------------- Configurable Type Buckets -------------------
// Adjust these to fine-tune which RIS types go into each table.
const PRESENTATION_TYPES = new Set(['CPAPER','CONF','SLIDE','ABST']);
const PTD_TYPES = new Set(['THES','DISS','RPRT']); // Projects/Theses/Dissertations
// Everything else falls into "Other Publications".

// ------------------- Utilities -------------------
const el = (sel) => document.querySelector(sel);
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const params = new URLSearchParams(location.search);

function debounce(fn, ms=300) { let t; return (...a)=>{ clearTimeout(t); t=setTimeout(()=>fn(...a), ms); }; }

function parseAuthorsToApa(authorsStr) {
  if (!authorsStr) return '';
  const raw = authorsStr.split(/;| and | & /i).map(s => s.trim()).filter(Boolean);
  const formatted = raw.map(name => {
    if (name.includes(',')) {
      const [last, rest] = name.split(',', 2).map(s => s.trim());
      const initials = rest ? rest.split(/\s+/).filter(Boolean).map(w => w[0].toUpperCase() + '.').join(' ') : '';
      return initials ? `${esc(last)}, ${esc(initials)}` : `${esc(last)}`;
    } else {
      const parts = name.split(/\s+/).filter(Boolean);
      const last = parts.pop() || '';
      const initials = parts.map(w => w[0].toUpperCase() + '.').join(' ');
      return initials ? `${esc(last)}, ${esc(initials)}` : `${esc(last)}`;
    }
  });
  if (formatted.length > 20) {
    const first19 = formatted.slice(0, 19);
    const lastAuthor = formatted[formatted.length - 1];
    return first19.join(', ') + ', …, ' + lastAuthor;
  }
  if (formatted.length > 1) {
    return formatted.slice(0, -1).join(', ') + ', & ' + formatted[formatted.length - 1];
  }
  return formatted[0] || '';
}

function doiToUrl(doiRaw) {
  if (!doiRaw) return '';
  let doi = doiRaw.trim();
  if (doi === '') return '';
  if (/^https?:\/\//i.test(doi)) return doi;
  if (/^doi\.org\//i.test(doi)) return 'https://' + doi;
  if (/^10\./.test(doi)) return 'https://doi.org/' + encodeURI(doi);
  return doi;
}

// APA-style text without printing the URL/DOI (link icon is shown separately)
function formatAPA(rec) {
  const authors = parseAuthorsToApa(rec.authors || '');
  const year = rec.year ? `(${String(rec.year)})` : '(n.d.)';
  const title = rec.title ? esc(rec.title) : '[No title]';

  const type = (rec.ref_type || '').toUpperCase();
  const hasJournal = !!rec.journal;

  // Journal article heuristic
  if (type === 'JOUR' || hasJournal) {
    const journal = rec.journal ? `<i>${esc(rec.journal)}</i>` : '';
    const volume = rec.volume ? `<i>${esc(rec.volume)}</i>` : '';
    const issue = rec.issue ? `(${esc(rec.issue)})` : '';
    const volIss = (volume && issue) ? `${volume}${issue}` : (volume || issue);
    const pages = rec.pages ? `${esc(rec.pages)}` : '';

    let str = '';
    if (authors) str += `${authors} `;
    str += `${year}. ${title}. `;
    if (journal) {
      str += `${journal}`;
      if (volIss) str += `, ${volIss}`;
      if (pages) str += `, ${pages}`;
      str += '.';
    }
    return str;
  }

  // Book heuristic
  if (type === 'BOOK' || (!hasJournal && rec.publisher)) {
    const publisher = rec.publisher ? esc(rec.publisher) : '';
    let str = '';
    if (authors) str += `${authors} `;
    str += `${year}. <i>${title}</i>`;
    if (publisher) str += `. ${publisher}.`;
    else str += '.';
    return str;
  }

  // Fallback (generic)
  let str = '';
  if (authors) str += `${authors} `;
  str += `${year}. ${title}.`;
  if (rec.ref_type) str += ` (${esc(rec.ref_type)}).`;
  if (rec.publisher) str += ` ${esc(rec.publisher)}.`;
  if (rec.journal) str += ` ${esc(rec.journal)}.`;
  return str;
}

function bestLink(rec) {
  const d = doiToUrl(rec.doi || '');
  if (d) return d;
  if (rec.url && String(rec.url).trim() !== '') return rec.url;
  return '';
}

function typeBucket(rec) {
  const t = (rec.ref_type || '').toUpperCase();
  if (PRESENTATION_TYPES.has(t)) return 'presentations';
  if (PTD_TYPES.has(t)) return 'ptd';
  return 'other';
}

// Link icon (SVG) button
function linkIcon(href) {
  const safe = esc(href);
  const label = 'Open link in a new tab';
  return `<a class="link-btn" href="${safe}" target="_blank" rel="noopener noreferrer" aria-label="${label}" title="${label}">
    <svg class="link-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M10 13a5 5 0 0 0 7.07 0l3.54-3.54a5 5 0 0 0-7.07-7.07L12 4" />
      <path d="M14 11a5 5 0 0 0-7.07 0L3.39 14.54a5 5 0 0 0 7.07 7.07L12 20" />
    </svg>
  </a>`;
}

// ------------------- UI State -------------------
const qs = {
  q: el('#q'),
  sort: el('#sort'),
  clearBtn: el('#clearBtn'),
  totalCount: el('#totalCount'),
  queryInfo: el('#queryInfo'),
  tbodyPresentations: el('#tbodyPresentations'),
  tbodyPTD: el('#tbodyPTD'),
  tbodyOther: el('#tbodyOther'),
  countPresentations: el('#countPresentations'),
  countPTD: el('#countPTD'),
  countOther: el('#countOther'),
};

let state = {
  q: params.get('q') || '',
  sort: params.get('sort') || 'type_asc',
};

qs.q.value = state.q;
qs.sort.value = state.sort;

function setUrlFromState() {
  const p = new URLSearchParams();
  if (state.q) p.set('q', state.q);
  if (state.sort) p.set('sort', state.sort);
  history.replaceState(null, '', location.pathname + (p.toString() ? '?' + p.toString() : ''));
}

async function fetchData() {
  const p = new URLSearchParams({
    action: 'search',
    q: state.q,
    sort: state.sort,
  });
  const res = await fetch(location.pathname + '?' + p.toString(), { headers: { 'Accept': 'application/json' } });
  if (!res.ok) throw new Error('Network error');
  return res.json();
}

function renderTables(payload) {
  const { items, total } = payload;
  qs.totalCount.textContent = total;
  qs.queryInfo.textContent = state.q ? ` — Search: "${state.q}"` : '';

  const present = [];
  const ptd = [];
  const other = [];

  for (const rec of (items || [])) {
    const bucket = typeBucket(rec);
    if (bucket === 'presentations') present.push(rec);
    else if (bucket === 'ptd') ptd.push(rec);
    else other.push(rec);
  }

  qs.countPresentations.textContent = `(${present.length})`;
  qs.countPTD.textContent = `(${ptd.length})`;
  qs.countOther.textContent = `(${other.length})`;

  const buildRow = (rec) => {
    const apa = formatAPA(rec);
    const link = bestLink(rec);
    const linkCell = link ? linkIcon(link) : '';
    const type = esc(rec.ref_type || '');
    return `<tr data-id="${rec.id}">
      <td class="col-type">${type}</td>
      <td>${apa}</td>
      <td class="col-link">${linkCell}</td>
    </tr>`;
  };

  qs.tbodyPresentations.innerHTML = present.map(buildRow).join('') || `<tr><td class="col-type"></td><td>No results.</td><td class="col-link"></td></tr>`;
  qs.tbodyPTD.innerHTML = ptd.map(buildRow).join('') || `<tr><td class="col-type"></td><td>No results.</td><td class="col-link"></td></tr>`;
  qs.tbodyOther.innerHTML = other.map(buildRow).join('') || `<tr><td class="col-type"></td><td>No results.</td><td class="col-link"></td></tr>`;
}

const refresh = debounce(async () => {
  setUrlFromState();
  try {
    const payload = await fetchData();
    renderTables(payload);
  } catch (e) {
    qs.tbodyPresentations.innerHTML = `<tr><td class="col-type"></td><td>Failed to load.</td><td class="col-link"></td></tr>`;
    qs.tbodyPTD.innerHTML = `<tr><td class="col-type"></td><td>Failed to load.</td><td class="col-link"></td></tr>`;
    qs.tbodyOther.innerHTML = `<tr><td class="col-type"></td><td>Failed to load.</td><td class="col-link"></td></tr>`;
  }
}, 200);

// Events
qs.q.addEventListener('input', () => { state.q = qs.q.value.trim(); refresh(); });
qs.sort.addEventListener('change', () => { state.sort = qs.sort.value; refresh(); });
qs.clearBtn.addEventListener('click', () => { state.q = ''; qs.q.value=''; refresh(); });

// Initial load
refresh();
</script>
</body>
</html>
