# DreamCMS Modernized Baseline

This is a compatibility-first modernization of the archived DreamCMS project.

## Install

### Backend
```bash
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate
```

### Frontend
```bash
nvm use 24.14.0
npm install
npm run production
```

### Admin frontend
```bash
cd admin
nvm use 24.14.0
npm install
npm run production
```

### Realtime server
```bash
node node.js
```

## Notes
- The codebase keeps the archived route and domain structure.
- A full Vue 3 rewrite was intentionally not forced because it would require rewriting most SPA modules instead of upgrading them.
- Backpack stays on v6 because that is the current compatibility path for Laravel 10/11/12 in the archived admin CRUD code.
