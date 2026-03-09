<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'NOVICHEK') }}</title>
    <meta name="description" content="{{ config('seo.default_description') }}">
    <meta name="keywords" content="1с, маркировка, сайты, чат-боты, автоматизация, vpn">
    <meta property="og:title" content="{{ config('seo.default_title') }}">
    <meta property="og:description" content="{{ config('seo.default_description') }}">
    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>
<body class="bg-slate-950 text-slate-50">
<div id="app"></div>
</body>
</html>
