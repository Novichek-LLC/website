# ООО «Новичёк» — обновлённый кодовый архив

В архиве собран расширенный Laravel + Vue starter с реализованными доработками по архитектуре и исходникам:

## Что добавлено

- аутентификация админки в стиле Breeze
- лиды и CRM-воронка
- уведомления по email и Telegram
- файловое хранилище кейсов и блога
- realtime-чат через Reverb / Echo
- SEO-конфиг и реальный контент

## Запуск

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan install:broadcasting --reverb
composer run dev
```

## Примечание

Это не архив с vendor и node_modules. Это полный набор исходников и конфигов под доработанный проект.
