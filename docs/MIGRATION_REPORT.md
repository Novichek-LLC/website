# Migration report

## Source material used
- Original Laravel application from the archive.
- Archived public fonts, images, TinyMCE plugins and admin sources.
- Original route files, controllers, models and migrations.

## Mechanical changes applied
- Replaced the original Composer manifest with a Laravel 12 / PHP 8.3 baseline.
- Moved forum search to `baril/sqlout` because the original Scout MySQL driver is abandoned.
- Added local `app/Censure.php` shim to replace brittle package behavior.
- Switched the main frontend and the admin frontend to Laravel Mix 6 / Webpack 5 while preserving the archived directory layout.
- Replaced private Font Awesome npm usage with local archived assets from `resources/font`.
- Added `.nvmrc` pins for Node 24.14.0 LTS in both frontend roots.
- Updated the Socket.IO server to use `axios` instead of `request` for the text-filter callback.
- Updated the skin image pipeline towards Intervention Image v3 style calls.

## Files changed intentionally
- `composer.json`
- `package.json`
- `admin/package.json`
- `webpack.mix.js`
- `admin/webpack.mix.js`
- `resources/js/auth.js`
- `admin/resources/js/bootstrap.js`
- `resources/css/_basement.scss`
- `node.js`
- `app/Libraries/Skinlib.php`
- `app/Http/Controllers/API/SkinController.php`
- `app/Http/Controllers/SkinController.php`
- `app/Models/Forum/Discussion.php`
- `app/Models/Forum/Post.php`
- `app/Models/Category.php`
- `app/Models/Article.php`
- `app/Models/Tag.php`
- `install.php`

## Open risks
- Backpack 6 CRUD controllers may still need field-by-field API adjustments.
- The legacy Socket.IO chat stack still uses protocol v2 semantics.
- Some Vue 2 runtime libraries are intentionally pinned for compatibility, not because they are modern.
