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

mix.js('resources/js/app.js', 'public/js').vue()
    .sass('resources/sass/app.scss', 'public/css')
    .scripts([
        'resources/js/allextra/myscript.js',
        'resources/js/allextra/dashboard.init.js',
        'resources/js/allextra/app.js',
    ], 'public/js/extra.js')
    .styles([
        'resources/css/icons.min.css',
        'resources/css/app.min.css',    
        'resources/css/mystyle.css',    
    ], 'public/css/all.css')
    .webpackConfig(require('./webpack.config'));

if (mix.inProduction()) {
    mix.version();
}