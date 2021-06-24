const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .setPublicPath(path.normalize('public/assert'))
    .setResourceRoot('/assert')
    .js('resources/js/app.js', 'js')
    .postCss('resources/css/app.css', 'css', [
        //
    ]).version();

mix.sourceMaps();
mix.webpackConfig({
    devServer: {
        host: '0.0.0.0',
    },
    resolve:{
        alias: {
            'vue-router$': 'vue-router/dist/vue-router.common.js'
        }
    }
});
