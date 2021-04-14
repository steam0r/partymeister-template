const mix = require('laravel-mix');
const { env } = require('minimist')(process.argv.slice(2));

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

/* do stuff with mix that's common to all sites, like maybe mix.options() */

// load site-specific config
if (env && env.site) {
    require(`${__dirname}/webpack.mix.${env.site}.js`);
}

