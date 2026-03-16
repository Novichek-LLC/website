# Realtime migration log

1. Extracted the archive and mapped routes, controllers and models.
2. Chose Laravel 12 + PHP 8.3 for the backend.
3. Kept Vue 2.7 in place and moved both frontends to Laravel Mix 6 / Webpack 5 as the least-destructive stable build baseline.
4. Replaced private Font Awesome npm dependency with archived local font assets.
5. Added an axios compatibility bootstrap for the main SPA.
6. Switched forum search models from the abandoned Scout MySQL driver to Sqlout.
7. Added a local Censure shim and normalized obscene filter imports.
8. Simplified the project manifests and added Node 24 LTS pinning via `.nvmrc`.
