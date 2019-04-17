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

mix.webpackConfig({
    resolve: {
        modules: [
            'node_modules',
            'vendor/tightenco',
            'vendor/motor-cms',
            'resources/assets/js',
            'packages/dfox288'
        ],
        extensions: [".webpack.js", ".web.js", ".js", ".json", ".less"]
    }
});

mix
    .js('resources/assets/js/project.package-development.js', 'public/js/motor-backend.js')
    .js('packages/dfox288/partymeister-accounting/resources/assets/js/partymeister-accounting-pos/main.package-development.js', 'public/js/partymeister-accounting-pos.js')
    .sourceMaps()
    .sass('resources/assets/sass/project.package-development.scss', 'public/css/motor-backend.css')
    .sass('packages/dfox288/partymeister-accounting/resources/assets/sass/partymeister-accounting-pos.scss', 'public/css')
    // APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/images/*.*', 'public/images')
;
if (mix.config.inProduction) {
    mix.version();
}
