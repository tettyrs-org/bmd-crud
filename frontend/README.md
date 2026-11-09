# bmd-crud-frontend

Vue 3 single-page application for the BMD (Barang Milik Daerah) CRUD application: asset list with search, filters and pagination, asset form, and per-room report.

- Vue 3, Vite 5, Vue Router 4, Axios

## Setup

```bash
npm install
npm run dev                   # http://localhost:5173
```

Vite forwards `/api/*` to `http://127.0.0.1:8000`, so run the backend (`bmd-crud-backend`) at the same time.

## Build

```bash
npm run build
```

## Notes

- Requires Node.js 20+.
- Vite 5 is pinned because Vite 6+ requires a newer Node.js runtime.
