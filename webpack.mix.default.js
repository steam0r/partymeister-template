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
            'packages'
        ],
        alias: {
            "ziggy": path.resolve('resources/assets/js/ziggy.js'),
            "ziggy-route": path.resolve('vendor/tightenco/ziggy/src/js/route.js'),
        },
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less"]
    }
});

mix
    .js('resources/assets/js/project.default.js', 'public/js/motor-backend.js')

    .js('@partymeister-frontend/resources/assets/js/partymeister-livevoting/main.js', 'public/js/partymeister-livevoting.js')
    .js('@partymeister-slides/resources/assets/js/partymeister-slidemeister-web/main.js', 'public/js/partymeister-slidemeister-web.js')
    .js('@partymeister-frontend/resources/assets/js/partymeister-frontend/main.js', 'public/js/partymeister-frontend.js')
    .js('@partymeister-slides/resources/assets/js/partymeister-slides/partymeister-slides-frontend.js', 'public/js/partymeister-slides-frontend.js')
    .sourceMaps()
    .sass('resources/assets/sass/project.default.scss', 'public/css/motor-backend.css')
    .sass('@partymeister-frontend/resources/assets/sass/partymeister-livevoting.scss', 'public/css')
    .sass('@partymeister-slides/resources/assets/sass/partymeister-slidemeister-web.scss', 'public/css')
    .sass('@partymeister-accounting/resources/assets/sass/partymeister-accounting-pos.scss', 'public/css')
    .sass('@partymeister-frontend/resources/assets/sass/partymeister-frontend.scss', 'public/css')
    // APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/images/*.*', 'public/images')
;
if (mix.config.inProduction) {
    mix.version();
}
