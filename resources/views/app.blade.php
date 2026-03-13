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
    <script>
  (function () {
    try {
      const saved = localStorage.getItem('site-theme');
      const prefersLight = window.matchMedia('(prefers-color-scheme: light)').matches;
      const theme = saved === 'light' || saved === 'dark'
        ? saved
        : (prefersLight ? 'light' : 'dark');

      document.documentElement.classList.add(theme === 'light' ? 'theme-light' : 'theme-dark');
      document.documentElement.setAttribute('data-theme', theme);
    } catch (e) {}
  })();
</script>
    @vite(['resources/css/app.css', 'resources/js/main.js'])
</head>
<body class="bg-slate-950 text-slate-50">
<div id="app"></div>
</body>
</html>
