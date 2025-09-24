// citations.js
// Client-side rendering of CSL JSON / Zotero items into an APA-like citation table
// Ben McMurry, 2024-06-20
//
// ---------- Pager ----------
let currentPage = 1;
let pageSize = 10;

function paginate(rows) {
    console.log("Paginate:", { currentPage, pageSize, total: rows.length });
    const total = rows.length;
    const pages = Math.max(1, Math.ceil(total / pageSize));
    if (currentPage > pages) currentPage = pages;
    const start = (currentPage - 1) * pageSize;
    const end = start + pageSize;
    const slice = rows.slice(start, end);
    return { slice, total, pages };
}

function updatePager(total, pages) {
    byId("pageNum").textContent = String(currentPage);
    byId("pageCount").textContent = String(pages);
    // disable prev/next at bounds
    byId("prev").disabled = currentPage <= 1;
    byId("next").disabled = currentPage >= pages;
    // update "shown" / "total" counters (shown = current page slice)
    byId("shown").textContent = String(document.querySelectorAll("#tbody tr").length);
    byId("total").textContent = String(total);
}

// ---------- Tiny helpers ----------
const $ = s => document.querySelector(s);
const byId = id => document.getElementById(id);
const clean = s => (s ?? "").toString().trim();
const notEmpty = s => !!clean(s);

function getYear(it) {
    const dp = it?.issued?.["date-parts"];
    if (Array.isArray(dp) && Array.isArray(dp[0]) && dp[0][0]) {
        const y = Number(dp[0][0]); return Number.isFinite(y) ? y : String(dp[0][0]);
    }
    if (it.year) return Number(it.year) || String(it.year);
    if (typeof it.issued === "string") { const m = it.issued.match(/\d{4}/); if (m) return Number(m[0]); }
    return "";
}

function doiUrl(doi) {
    if (!doi) return "";
    const bare = doi.replace(/^https?:\/\/(dx\.)?doi\.org\//i, "");
    return "https://doi.org/" + bare;
}

function pickUrl(it) {
    if (it.DOI) return doiUrl(it.DOI);
    if (it.URL) return it.URL;
    if (typeof it.id === "string" && /^https?:\/\//.test(it.id)) return it.id;
    return "";
}

// --- Authors -> "Family, G. G., Family, G. G., & Family, G. G."
function authorsAPA(it) {
    const A = Array.isArray(it.author) ? it.author : [];
    const names = A.map(a => {
        if (typeof a === "string") return a;
        if (a.literal) return a.literal;
        const fam = clean(a.family);
        const giv = clean(a.given);
        const inits = giv ? giv.split(/\s+/).map(x => x[0]?.toUpperCase()).filter(Boolean).join(". ") + "." : "";
        return [fam, inits].filter(Boolean).join(", ");
    }).filter(Boolean);
    if (names.length === 0) return "";
    if (names.length === 1) return names[0];
    if (names.length === 2) return names[0] + " & " + names[1];
    return names.slice(0, -1).join(", ") + ", & " + names[names.length - 1];
}

// --- Sentence-case title? We'll leave provided casing (safer for proper nouns)
function titleAPA(it) {
    return clean(it.title) || "[Untitled]";
}

// --- For books/theses, an institution/publisher cue
function institutionAPA(it) {
    return clean(it["publisher"]) || clean(it["publisher-place"]) || clean(it["event-place"]) || "";
}

// --- Container (journal, proceedings, site, etc.)
function containerAPA(it) {
    return clean(it["container-title"]) || clean(it["event-title"]) || clean(it["collection-title"]) || clean(it["source"]) || "";
}

// --- Volume(issue), pages
function volIssuePages(it) {
    const vol = clean(it.volume);
    const iss = clean(it.issue || it.number);
    const pgs = clean(it.page || it.pages);
    let s = "";
    if (vol) s += `<i>${escapeHtml(vol)}</i>`;
    if (iss) s += `(${escapeHtml(iss)})`;
    if (pgs) s += (s ? ", " : "") + escapeHtml(pgs);
    return s;
}

// --- Derive Type per your rules
var pubCount = 0;
var thesisCount = 0;
var presentationCount = 0;
var otherCount = 0;
function deriveType(it) {
    const type = (it.type || "").toLowerCase();
    const genre = (it.genre || "").trim();

    const pubs = new Set(["article-journal", "post-weblog", "book", "chapter", "paper-conference", "document"]);
    if (pubs.has(type)) {
        pubCount++;
        return "Publication";
    }
    if (type === "thesis") {
        thesisCount++;
        return genre || "Thesis";
    }
    if (type === "speech") {
        presentationCount++;
        return "Presentation";
    }
    otherCount++;
  
    // Fallback mix of type + genre (nice label)
    const cap = s => s ? s.replace(/(^|[\s_-])\w/g, m => m.toUpperCase()) : "";
    const parts = [cap(type.replace(/[-_]/g, " ")), cap(genre)];
    const mixed = parts.filter(Boolean).join(" / ");
    return mixed || "Other";
}

// --- Build an APA-like citation string with graceful fallbacks
function citationAPA(it) {
    const A = authorsAPA(it);
    const Y = getYear(it);
    const T = titleAPA(it);
    const C = containerAPA(it);
    const VIP = volIssuePages(it);
    const Inst = institutionAPA(it);
    const URL = pickUrl(it);

    const type = (it.type || "").toLowerCase();

    // Coarse tailoring by type family:
    if (type === "book") {
        // Author. (Year). Title. Publisher. URL/DOI
        return joinParts([
            A, yearPart(Y), `<i>${escapeHtml(T)}</i>`, Inst || C, urlPart(URL)
        ]);
    }
    if (type === "thesis") {
        // Author. (Year). Title [Genre, Institution]. URL
        const g = clean(it.genre) || "Thesis";
        const inst = clean(it["publisher"]) || clean(it["publisher-place"]) || clean(it["event-place"]) || clean(it["archive"]) || "";
        const bracket = inst ? `[${escapeHtml(g)}, ${escapeHtml(inst)}]` : `[${escapeHtml(g)}]`;
        return joinParts([
            A, yearPart(Y), `<i>${escapeHtml(T)}</i> ${bracket}`, urlPart(URL)
        ]);
    }
    if (type === "speech" || type === "paper-conference") {
        // Author. (Year). Title. In Event title, Event place. URL
        const where = joinParts([C, Inst], ", ");
        return joinParts([
            A, yearPart(Y), T + ".", where, urlPart(URL)
        ]);
    }
    if (type === "post-weblog") {
        // Author. (Year). Title. Site. URL
        return joinParts([
            A, yearPart(Y), T + ".", C || Inst, urlPart(URL)
        ]);
    }
    if (type === "article-journal" || type === "chapter") {
        // Author. (Year). Title. Container, volume(issue), pages. DOI/URL
        const tail = joinParts([C && `<i>${escapeHtml(C)}</i>`, VIP], ", ");
        return joinParts([
            A, yearPart(Y), T + ".", tail, urlPart(URL)
        ]);
    }
    // document / other
    return joinParts([
        A, yearPart(Y), T + ".", C || Inst, urlPart(URL)
    ]);
}

function yearPart(Y) { return Y ? `(${Y}).` : "(n.d.)."; }
function urlPart(u) { return u ? `<a href="${u}" target="_blank" rel="noopener">${escapeHtml(u)}</a>` : ""; }
function joinParts(arr, sep = " ") { return arr.filter(x => notEmpty(stripTags(x))).join(sep).replace(/\s+/g, " ").trim(); }
function stripTags(s) { return String(s ?? "").replace(/<[^>]*>/g, "").trim(); }

// ---------- Table plumbing ----------
let RAW = [], DATA = [];
let sortKey = "year", sortDir = "desc";

function normalize(it, i) {
    return {
        _i: i,
        year: getYear(it),
        cite: citationAPA(it),
        derivedType: deriveType(it),
        raw: it
    };
}

function render(rows) {
    const tb = byId("tbody");
    tb.innerHTML = "";
    const frag = document.createDocumentFragment();
    rows.forEach(r => {
        const tr = document.createElement("tr");
        tr.appendChild(td(`<span class="">${escapeHtml(r.year || "")}</span>`));
        tr.appendChild(td(r.cite));
        tr.appendChild(td(escapeHtml(r.derivedType)));
        frag.appendChild(tr);
    });
    tb.appendChild(frag);
    byId("shown").textContent = String(rows.length);
    byId("total").textContent = String(RAW.length);
}

function td(html) { const n = document.createElement("td"); n.innerHTML = html; return n; }
function escapeHtml(s) { return String(s ?? "").replace(/[&<>"']/g, m => ({ "&": "&amp;", "<": "&lt;", ">": "&gt;", "\"": "&quot;", "'": "&#039;" }[m])); }

function apply() {
    const q = byId("q").value.toLowerCase().trim();

    let rows = DATA.filter(r => {
        if (!q) return true;
        const it = r.raw;
        const hay = [
            r.cite, r.derivedType, r.year,
            it.title, authorsAPA(it), containerAPA(it),
            institutionAPA(it), pickUrl(it)
        ].join(" ").toLowerCase();
        return hay.includes(q);
    });

    // sort (unchanged)
    rows.sort((a, b) => {
        const ka = a[sortKey], kb = b[sortKey];
        const numSort = (sortKey === "year");
        let v;
        if (numSort) {
            const na = Number(ka) || -Infinity, nb = Number(kb) || -Infinity;
            v = na - nb;
        } else {
            v = String(ka).localeCompare(String(kb), undefined, { sensitivity: "base" });
        }
        return sortDir === "asc" ? v : -v;
    });

    // NEW: paginate
    const { slice, total, pages } = paginate(rows);
    render(slice);
    updatePager(total, pages);
}

function setSortFromHeader(th) {
    const key = th.dataset.key;
    if (!key) return;
    if (sortKey === key) { sortDir = (sortDir === "asc") ? "desc" : "asc"; }
    else { sortKey = key; sortDir = key === "year" ? "desc" : "asc"; }
    apply();
}

function ingest(arr) {
    if (!Array.isArray(arr)) { alert("Expected a JSON array of CSL/Zotero items."); return; }
    RAW = arr; DATA = arr.map(normalize); apply();
    renderSummary(); // NEW: build summary from RAW
}

// ---------- Summary table from JSON (Total + current year and 4 prior) ----------
function renderSummary() {
    const host = byId("citationsSummary");
    if (!host) return;

    const BUCKETS = [
        "Publications",
        "Presentations",
        "MA Theses",
        "MA Projects",
        "Dissertations",
        "Other"
    ];

    function getBucket(it) {
        const type = (it.type || "").toLowerCase();
        const genre = (it.genre || "").toLowerCase();
        const title = (it.title || "").toLowerCase();
        const text = genre + " " + title;

        if (type === "speech" || type === "paper-conference") return "Presentations";

        if (type === "thesis") {
            if (/dissertation|phd/.test(text)) return "Dissertations";
            if (/project/.test(text)) return "MA Projects";
            return "MA Theses";
        }

        const PUB_TYPES = new Set([
            "article-journal", "book", "chapter",
            "post-weblog", "document", "report",
            "article-magazine", "article-newspaper"
        ]);
        if (PUB_TYPES.has(type)) return "Publications";

        return "Other";
    }

    const now = new Date();
    const currentYear = now.getFullYear();
    const minYear = currentYear - 4;

    const totalsByBucket = Object.fromEntries(BUCKETS.map(b => [b, 0]));
    const countsByBucketYear = Object.fromEntries(
        BUCKETS.map(b => [b, Object.fromEntries(Array.from({ length: 5 }, (_, i) => [currentYear - i, 0]))])
    );

    RAW.forEach(it => {
        const b = getBucket(it);
        if (!(b in totalsByBucket)) return;
        totalsByBucket[b]++;
        const y = Number(getYear(it));
        if (Number.isFinite(y) && y >= minYear && y <= currentYear) {
            countsByBucketYear[b][y]++;
        }
    });

    let headerHtml = `<th>Year</th><td>Total**</td>`;
    for (let y = currentYear; y >= minYear; y--) {
        const mark = (y === currentYear) ? '*' : '';
        headerHtml += `<td>${y}${mark}</td>`;
    }

    const bodyHtml = BUCKETS.map(bucket => {
        let cells = `<th scope='row'>${bucket}</th><td>${totalsByBucket[bucket]}</td>`;
        for (let y = currentYear; y >= minYear; y--) {
            cells += `<td>${countsByBucketYear[bucket][y]}</td>`;
        }
        return `<tr>${cells}</tr>`;
    }).join("\n");

    host.innerHTML = `
      <table class='table table-striped'>
        <thead><tr>${headerHtml}</tr></thead>
        <tbody>
          ${bodyHtml}
        </tbody>
      </table>
      <p align="center">**Data collection started in 2008, but there are recorded citations as early as 2001.</p>
      <p align="center">*current year</p>
    `;
}

// ---------- Loaders & UI ----------
async function loadDefault() {
    try {
        const res = await fetch("elc.json", { cache: "no-store" });
        if (!res.ok) throw new Error(res.status + " " + res.statusText);
        const arr = await res.json();
        ingest(arr);
    } catch (e) { alert('Could not load "elc.json".\n\n' + e.message); }
        console.log({"Publications": pubCount, "Theses": thesisCount, "Presentations": presentationCount, "Other": otherCount});
}

function readFile(file) {
    const reader = new FileReader();
    reader.onload = () => { try { ingest(JSON.parse(reader.result)); } catch (e) { alert("Invalid JSON.\n" + e.message); } };
    reader.readAsText(file);
}
byId("q").addEventListener("input", apply);
// remove duplicate addEventListener by ensuring we only bind once for sortable headers
Array.from(document.querySelectorAll("th.sortable")).forEach(th => th.addEventListener("click", () => setSortFromHeader(th)));

// page size
byId("pageSize").addEventListener("change", (e) => {
    pageSize = parseInt(e.target.value, 10) || 25;
    currentPage = 1;
    apply();
});

// pager buttons
byId("prev").addEventListener("click", () => {
    if (currentPage > 1) { currentPage--; apply(); }
});
byId("next").addEventListener("click", () => {
    currentPage++; // guard happens in paginate()
    apply();
});

// search resets to page 1
byId("q").addEventListener("input", () => {
    currentPage = 1;
    apply();
});

// when sorting, also reset to page 1
function setSortFromHeader(th) {
    const key = th.dataset.key;
    if (!key) return;
    if (sortKey === key) { sortDir = (sortDir === "asc") ? "desc" : "asc"; }
    else { sortKey = key; sortDir = key === "year" ? "desc" : "asc"; }
    currentPage = 1;             // NEW
    apply();
}

loadDefault();
