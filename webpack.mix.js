const mix = require('laravel-mix');
const { env } = require('minimist')(process.argv.slice(2));

/* do stuff with mix that's common to all sites, like maybe mix.options() */

// load site-specific config
if (env && env.site) {
    require(`${__dirname}/webpack.mix.${env.site}.js`);
}

