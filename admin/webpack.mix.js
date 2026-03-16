const mix = require('laravel-mix');
const path = require('path');

mix.autoload({
    jquery: ['$', 'window.jQuery', 'jQuery'],
});

mix.webpackConfig({
    resolve: {
        alias: {
            Api: path.resolve(__dirname, 'resources/js/api/'),
            WebServices: path.resolve(__dirname, 'resources/js/webServices/'),
            Components: path.resolve(__dirname, 'resources/js/components/'),
            Constants: path.resolve(__dirname, 'resources/js/constants/'),
            Container: path.resolve(__dirname, 'resources/js/container/'),
            Views: path.resolve(__dirname, 'resources/js/views/'),
            Helpers: path.resolve(__dirname, 'resources/js/helpers/'),
            Themes: path.resolve(__dirname, 'resources/js/themes/'),
            Pages: path.resolve(__dirname, 'resources/js/pages/'),
        },
    },
    output: {
        publicPath: '/assets/vuexy/',
        chunkFilename: 'chunks/[name].js',
    },
});

mix.js('resources/js/main.js', 'public/js')
   .vue({ version: 2 })
   .sass('resources/js/assets/scss/_style.scss', 'public/css/style.css');

mix.options({ extractVueStyles: true });

if (!mix.inProduction()) {
    mix.sourceMaps();
}

mix.copyDirectory('public/css', '../public/assets/vuexy/css');
mix.copyDirectory('public/js', '../public/assets/vuexy/js');
mix.copyDirectory('chunks', '../public/assets/vuexy/chunks');
