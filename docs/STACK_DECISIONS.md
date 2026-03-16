# Stack decisions

## Backend
- PHP 8.3
- Laravel 12
- Backpack 6 for compatibility with the archived admin CRUD code
- JWT auth retained to preserve existing API contract
- Laravel Scout + Sqlout to replace the abandoned MySQL Scout driver

## Frontend
- Node 24.14.0 LTS baseline
- Laravel Mix 6 + Webpack 5 as the highest practical stable build baseline that preserves the archived Vue 2 SPA structure
- Vue 2.7.16 retained for compatibility with the archived components
- Local Font Awesome assets from the archive are used instead of the private npm package

## Realtime
- Existing Socket.IO chat server retained in compatibility mode
- Deprecated `request` calls replaced with `axios`

## What was intentionally removed
- RoadRunner-specific packages and config as a first-class requirement
- Legacy package references that were abandoned or blocked Laravel 12 upgrades
