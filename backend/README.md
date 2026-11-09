# bmd-crud-backend

Laravel 13 RESTful API for the BMD (Barang Milik Daerah) CRUD application: assets, rooms, and a per-room asset report.

- PHP 8.2+ with `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `zip`
- MySQL / MariaDB

## Setup

```bash
cp .env.example .env          # Windows: copy .env.example .env
composer install
php artisan key:generate
# Fill in DB_* in .env for your local database
php artisan migrate --seed
php artisan serve             # http://127.0.0.1:8000
```

## Endpoints

| Method | Path | Description |
|---|---|---|
| GET | `/api/rooms` | List rooms |
| GET, POST | `/api/assets` | List (paginated, filterable) / create assets |
| GET, PUT, DELETE | `/api/assets/{id}` | Show / update / soft-delete an asset |
| GET | `/api/reports/rooms` | Per-room summary (active assets only) |


## Notes

- `.env` is not tracked. Use `.env.example` as the reference.
- Authentication is not implemented yet.
