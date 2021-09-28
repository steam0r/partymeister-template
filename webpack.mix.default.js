const mix = require('laravel-mix');

mix.options({
    hmrOptions: {
        host: 'localhost',
        port: '8079'
    },
});

mix.webpackConfig({
    devServer: {
        port: '8079'
    },
});

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
            'vendor/motor-cms',
            'vendor/partymeister',
            'resources/assets/js',
            // 'packages'
        ],
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less", ".vue"]
    }
});

mix
    .js('resources/assets/js/project.default.js', 'public/js/motor-backend.js')

    .js('./vendor/partymeister/frontend/resources/assets/js/partymeister-livevoting/main.js', 'public/js/partymeister-livevoting.js')
    .js('./vendor/partymeister/slides/resources/assets/js/partymeister-slidemeister-web/main.js', 'public/js/partymeister-slidemeister-web.js')
    .js('./vendor/partymeister/frontend/resources/assets/js/partymeister-frontend/main.js', 'public/js/partymeister-frontend.js')
    .js('resources/assets/js/frontend.js', 'public/js/motor-frontend.js')
    .js('./vendor/partymeister/slides/resources/assets/js/slidemeister/frontend.js', 'public/js/slidemeister.js')
    .js('./vendor/partymeister/slides/resources/assets/js/font-loader.js', 'public/js/slidemeister-font-loader.js')
    .js('./vendor/partymeister/accounting/resources/assets/js/partymeister-accounting-pos.js', 'public/js/partymeister-accounting-pos.js')
    .vue()
    .sourceMaps()
    .sass('resources/assets/sass/project.default.scss', 'public/css/motor-backend.css')
    .sass('./vendor/partymeister/frontend/resources/assets/sass/partymeister-livevoting.scss', 'public/css')
    .sass('./vendor/partymeister/accounting/resources/assets/sass/partymeister-accounting-pos.scss', 'public/css')
    .sass('./vendor/partymeister/slides/resources/assets/sass/partymeister-slidemeister-web.scss', 'public/css')
    .sass('resources/assets/sass/partymeister-frontend.scss', 'public/css/motor-frontend.css')
    // APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/images/*.*', 'public/images')


    // .js('./vendor/partymeister/frontend/resources/assets/js/partymeister-livevoting/main.js', 'public/js/partymeister-livevoting.js')
    // .js('./vendor/partymeister/slides/resources/assets/js/partymeister-slidemeister-web/main.js', 'public/js/partymeister-slidemeister-web.js')
    // .js('./vendor/partymeister/frontend/resources/assets/js/partymeister-frontend/main.js', 'public/js/partymeister-frontend.js')
    // .vue()
    // .sourceMaps()
    // .sass('resources/assets/sass/project.default.scss', 'public/css/motor-backend.css')
    // .sass('./vendor/partymeister/frontend/resources/assets/sass/partymeister-livevoting.scss', 'public/css')
    // .sass('./vendor/partymeister/slides/resources/assets/sass/partymeister-slidemeister-web.scss', 'public/css')
    // .sass('./vendor/partymeister/accounting/resources/assets/sass/partymeister-accounting-pos.scss', 'public/css')
    // .sass('resources/assets/sass/partymeister-frontend.scss', 'public/css/motor-frontend.css')
    // // APP RESOURCES
    // .copy('resources/fonts/*.*', 'public/fonts')
    // .copy('resources/assets/images/*.*', 'public/images')
;
if (mix.inProduction()) {
    mix.version();
}
