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
        modules: [
            'node_modules',
            'vendor/tightenco',
            'resources/assets/js',
            'packages/dfox288'
        ],
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less"]
    }
});

mix
    .js('resources/assets/js/project.package-development.js', 'public/js/motor-backend.js')

    .js('packages/dfox288/partymeister-accounting/resources/assets/js/partymeister-accounting-pos/main.package-development.js', 'public/js/partymeister-accounting-pos.js')
    .js('packages/dfox288/partymeister-frontend/resources/assets/js/partymeister-livevoting/main.js', 'public/js/partymeister-livevoting.js')
    .js('packages/dfox288/partymeister-slides/resources/assets/js/partymeister-slidemeister-web/main.js', 'public/js/partymeister-slidemeister-web.js')
    .js('packages/dfox288/partymeister-frontend/resources/assets/js/partymeister-frontend/main.js', 'public/js/partymeister-frontend.js')
    .sourceMaps()
    .sass('resources/assets/sass/project.package-development.scss', 'public/css/motor-backend.css')
    .sass('packages/dfox288/partymeister-frontend/resources/assets/sass/partymeister-livevoting.scss', 'public/css')
    .sass('packages/dfox288/partymeister-slides/resources/assets/sass/partymeister-slidemeister-web.scss', 'public/css')
    .sass('packages/dfox288/partymeister-accounting/resources/assets/sass/partymeister-accounting-pos.scss', 'public/css')
    .sass('packages/dfox288/partymeister-frontend/resources/assets/sass/partymeister-frontend.scss', 'public/css')
    // APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/images/*.*', 'public/images')
;
if (mix.config.inProduction) {
    mix.version();
}
