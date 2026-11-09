<script setup>
import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <a href="#konten" class="skip-link">Lewati ke konten</a>
  <header class="topbar">
    <div class="brand">Aplikasi BMD</div>
    <nav class="nav" aria-label="Menu utama">
      <RouterLink to="/assets">Daftar Aset</RouterLink>
      <RouterLink to="/laporan">Laporan</RouterLink>
    </nav>
  </header>
  <main id="konten" class="container">
    <RouterView />
  </main>
</template>

<style>
:root {
  --primary: #2563eb;
  --primary-dark: #1e3a8a;
  --danger: #dc2626;
  --secondary: #6b7280;
  --text: #1f2937;
  --muted: #6b7280;
  --border: #e5e7eb;
  --bg: #f3f4f6;
  --surface: #ffffff;
  --radius: 8px;
  font-family: system-ui, -apple-system, 'Segoe UI', sans-serif;
  color: var(--text);
}
* { box-sizing: border-box; }
body { margin: 0; background: var(--bg); }
h2 { margin: 0; font-size: 22px; }

/* Aksesibilitas: link lewati ke konten, muncul saat fokus lewat keyboard */
.skip-link { position: absolute; left: -999px; top: 0; }
.skip-link:focus { left: 16px; top: 8px; z-index: 10; background: #fff; padding: 6px 10px; border-radius: 6px; }

.topbar { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px 16px; padding: 12px 16px; background: var(--primary-dark); color: #fff; }
.brand { font-weight: 700; font-size: 18px; }
.nav { display: flex; gap: 4px; flex-wrap: wrap; }
.nav a { color: #dbeafe; text-decoration: none; padding: 6px 12px; border-radius: 6px; }
.nav a:hover { background: rgba(255, 255, 255, .12); }
.nav a.router-link-active { background: #fff; color: var(--primary-dark); font-weight: 600; }
.nav a:focus-visible { outline: 2px solid #fff; outline-offset: 2px; }

.container { max-width: 1100px; margin: 20px auto; padding: 0 16px; }
.card { background: var(--surface); border-radius: var(--radius); padding: 20px; box-shadow: 0 1px 3px rgba(0, 0, 0, .08); }
.page-head { display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 12px; margin-bottom: 16px; }

.table-wrap { overflow-x: auto; border: 1px solid var(--border); border-radius: var(--radius); }
table { width: 100%; border-collapse: collapse; }
th, td { text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--border); font-size: 14px; white-space: nowrap; }
th { background: #f9fafb; font-size: 12px; color: var(--muted); font-weight: 600; text-transform: uppercase; letter-spacing: .04em; }
tbody tr:hover { background: #f9fafb; }
tbody tr:last-child td { border-bottom: 0; }
tfoot td { font-weight: 700; background: #f9fafb; }
.wrap { white-space: normal; }
.num { text-align: right; font-variant-numeric: tabular-nums; }
.empty { text-align: center; color: var(--muted); padding: 24px; }
.actions { text-align: right; white-space: nowrap; }
.actions > * + * { margin-left: 6px; }

.toolbar { display: flex; gap: 8px; flex-wrap: wrap; align-items: center; margin-bottom: 16px; }
.toolbar .search { flex: 1 1 260px; }
.toolbar select { width: auto; min-width: 150px; }
.pager { display: flex; gap: 12px; align-items: center; justify-content: flex-end; margin-top: 16px; color: var(--muted); font-size: 14px; }

input, select, textarea { width: 100%; padding: 9px 10px; border: 1px solid #d1d5db; border-radius: 6px; font: inherit; background: #fff; color: var(--text); }
input:focus-visible, select:focus-visible, textarea:focus-visible { outline: 2px solid #93c5fd; border-color: var(--primary); }
input.invalid, select.invalid, textarea.invalid { border-color: var(--danger); background: #fef2f2; }

.btn { display: inline-flex; align-items: center; justify-content: center; padding: 8px 14px; border: 1px solid transparent; border-radius: 6px; background: var(--primary); color: #fff; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: 500; line-height: 1.2; white-space: nowrap; }
.btn:hover { filter: brightness(.95); }
.btn:focus-visible { outline: 2px solid #1d4ed8; outline-offset: 2px; }
.btn:disabled { opacity: .5; cursor: not-allowed; }
.btn.secondary { background: var(--secondary); }
.btn.danger { background: var(--danger); }
.btn.ghost { background: #fff; color: var(--text); border-color: #d1d5db; }
.btn.sm { padding: 5px 10px; font-size: 13px; }

.form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px; }
.field { display: flex; flex-direction: column; gap: 6px; font-size: 14px; }
.field-label { font-weight: 500; }
.req { color: var(--danger); margin-left: 2px; }
.hint { color: var(--muted); font-size: 12px; }
.error { color: var(--danger); font-size: 13px; margin: 0; }
.alert { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 10px 12px; border-radius: 6px; margin-bottom: 16px; font-size: 14px; }
.full { grid-column: 1 / -1; }
.form-actions { display: flex; gap: 8px; justify-content: flex-end; padding-top: 16px; border-top: 1px solid var(--border); }

@media (max-width: 600px) {
  .card { padding: 14px; }
  th, td { font-size: 13px; padding: 8px; }
  .toolbar > * { flex: 1 1 100%; }
  .toolbar select { min-width: 0; }
  .form-actions { flex-direction: column-reverse; }
  .form-actions .btn { width: 100%; }
}
</style>
