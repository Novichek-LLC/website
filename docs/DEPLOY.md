# Deploy

## Nginx
- корень: `public/`
- PHP 8.2+
- websocket-proxy для Reverb на порт `8080`

## Supervisor
- `php artisan queue:work --tries=1`
- `php artisan reverb:start --host=0.0.0.0 --port=8080`
