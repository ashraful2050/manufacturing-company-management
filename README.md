# Manufacturing Company Management

Monorepo containing the Laravel backend and React frontend as separate projects.

## Structure

```
├── backend/    # Laravel 12 (Inertia.js server, API, DB)
└── frontend/   # React 18 + Vite (Inertia.js client)
```

## Getting Started

### Backend

```bash
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

### Frontend

```bash
cd frontend
npm install
npm run dev
```

### Run everything together (from backend/)

```bash
cd backend
composer run dev
```

> The Vite dev server outputs assets directly to `backend/public/build/`.
