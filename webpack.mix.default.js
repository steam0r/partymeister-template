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
    .js('resources/assets/js/modules/partymeister-accounting-pos/main.js', 'public/js/partymeister-accounting-pos.js')
    .js('resources/assets/js/modules/partymeister-livevoting/main.js', 'public/js/partymeister-livevoting.js')
    .js('resources/assets/js/modules/partymeister-slidemeister-web/main.js', 'public/js/partymeister-slidemeister-web.js')
    .js('resources/assets/js/modules/partymeister-frontend/main.js', 'public/js/partymeister-frontend.js')
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
