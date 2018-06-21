const {mix} = require('laravel-mix');

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

mix.webpackConfig({
    resolve: {
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less"]
    }
});

mix
    .js('resources/assets/js/project.js', 'public/js/motor-backend.js')
    .js('resources/assets/js/partymeister-pos.js', 'public/js')
    .js('resources/assets/js/partymeister-livevoting.js', 'public/js')
    .js('resources/assets/js/partymeister-slidemeister-web.js', 'public/js')
    .js('resources/assets/js/partymeister-frontend.js', 'public/js')
    .sourceMaps()
    .sass('resources/assets/sass/project.scss', 'public/css/motor-backend.css')
    .sass('resources/assets/sass/partymeister-livevoting.scss', 'public/css')
    .sass('resources/assets/sass/partymeister-slidemeister-web.scss', 'public/css')
    .sass('resources/assets/sass/partymeister-pos.scss', 'public/css')
    .sass('resources/assets/sass/partymeister-frontend.scss', 'public/css')
    // APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/images/*.*', 'public/images')
;
if (mix.config.inProduction) {
    mix.version();
}
