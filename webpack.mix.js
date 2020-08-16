const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
    .extract([
        'jquery',
        'bootstrap',
        'vue',
        'axios',
    ], 'public/js/vendor.js')

    .js('resources/js/app.js', 'public/js')

    .sass('resources/sass/app.scss', 'public/css')

    .version()
    .autoload({
        'moment': ['moment','window.moment'],
    });
