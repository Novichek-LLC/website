const mix = require('laravel-mix');
require('dotenv').config();

mix.options({
    processCssUrls: false
});

mix.webpackConfig({
    output: {
        chunkFilename: mix.inProduction() ? 'assets/js/[name].[chunkhash].js' : 'assets/js/[name].js'
    }
});

mix.js('resources/js/app.js', 'public/assets/js')
   .vue({ version: 2 })
   .sass('resources/css/style.scss', 'public/assets/css')
   .copy('resources/js/unitpay.js', 'public/assets/js/unitpay.js')
   .copyDirectory('resources/tinymce/plugins/spoiler', 'public/assets/js/plugins/spoiler')
   .copyDirectory('resources/font', 'public/assets/font')
   .copyDirectory('resources/img', 'public/assets/img')
   .copyDirectory('node_modules/tinymce/icons', 'public/assets/js/icons')
   .copyDirectory('node_modules/tinymce/skins', 'public/assets/js/skins')
   .copyDirectory('node_modules/tinymce/plugins', 'public/assets/js/plugins');

mix.minify('public/assets/js/unitpay.js');

if (mix.inProduction()) {
    mix.version();
} else {
    mix.sourceMaps();
}
