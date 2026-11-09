# bmd-crud

CRUD application for recording regional government assets (Barang Milik Daerah / BMD): asset data, status and condition, room location, and a per-room asset report.

- **backend/**: Laravel 13 REST API (PHP 8.2+, MySQL / MariaDB)
- **frontend/**: Vue 3 + Vite single-page application

## Running Locally

Prerequisites: PHP 8.2+ (with `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`), Composer, Node.js 20+, and MySQL / MariaDB.

### Backend

```bash
cd backend
cp .env.example .env          # Windows: copy .env.example .env
composer install
php artisan key:generate
# Fill in DB_* in .env for your local database
php artisan migrate --seed
php artisan serve             # http://127.0.0.1:8000
```

### Frontend

```bash
cd frontend
npm install
npm run dev                   # http://localhost:5173
```

Vite forwards `/api/*` requests to `http://127.0.0.1:8000`, so the backend must be running at the same time.

## Security Notes

- `.env` is not tracked. Use `.env.example` as the reference.
- Authentication is not implemented yet.
