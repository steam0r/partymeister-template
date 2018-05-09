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

mix.js('resources/assets/js/app.js', 'public/js')
    .js('resources/assets/js/pos.js', 'public/js')
    .js('resources/assets/js/slidemeister-web.js', 'public/js')
    .js('resources/assets/js/frontend.js', 'public/js')
    .sourceMaps()
    .sass('resources/assets/sass/slidemeister-web.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/pos.scss', 'public/css/pos.css')
    .sass('resources/assets/sass/frontend.scss', 'public/css/frontend.css')
    .combine([
        'public/css/app.css',
        'node_modules/select2/dist/css/select2.css',
        'node_modules/mediaelement/build/mediaelementplayer.css',
        'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
        'resources/assets/css/motor/backend.css',
        'resources/assets/css/motor/project.css',

        'resources/assets/css/partymeister/competitions.css',
        'resources/assets/css/partymeister/slides.css',

        'node_modules/@claviska/jquery-minicolors/jquery.minicolors.css',
        'node_modules/medium-editor/dist/css/medium-editor.css',
        'node_modules/medium-editor/dist/css/themes/beagle.css',
        'node_modules/tempusdominus-bootstrap-4/build/css/tempusdominus-bootstrap-4.min.css',
    ], 'public/css/all.css')
    .combine([
        'public/css/bootstrap.css',
        'public/css/pos.css'
    ], 'public/css/all-pos.css')
    //APP RESOURCES
    .copy('resources/fonts/*.*', 'public/fonts')
    .copy('resources/assets/img/*.*', 'public/img')
    .copy('resources/assets/images/*.*', 'public/images')
    .copy('resources/assets/js/partymeister/*.*', 'public/js/partymeister')
    //VENDOR RESOURCES
    .copy('node_modules/@claviska/jquery-minicolors/jquery.minicolors.png', 'public/css/')
    .copy('node_modules/medium-editor/dist/js/medium-editor.min.js', 'public/js/')
    // .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
    .copy('node_modules/simple-line-icons/fonts/*.*', 'public/fonts/')
    .copy('node_modules/mediaelement/build/mejs-controls.svg', 'public/images/vendor/')
    .copy('node_modules/moment/min/moment-with-locales.min.js', 'public/js');

if (mix.config.inProduction) {
    mix.version();
}
