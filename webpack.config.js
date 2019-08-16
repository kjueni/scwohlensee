var Encore = require('@symfony/webpack-encore');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/app.js and public/build/app.css
    .addEntry('app', './assets/js/app.js')
    .addEntry('favicon', './assets/img/favicon.ico')
    .addEntry('admin', './assets/js/admin.js')

    // allow sass/scss files to be processed
    .enableSassLoader(function(sassOptions) {
        sassOptions.includePaths = ['node_modules/foundation-sites/scss'];
    }/*, {
        resolveUrlLoader: false
     }*/)

    // allow legacy applications to use $/jQuery as a global variable
    .autoProvidejQuery()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    //.enableBuildNotifications()

// create hashed filenames (e.g. app.abc123.css)
// .enableVersioning()
;

//const UglifyJSPlugin = require('uglifyjs-webpack-plugin');

const config = Encore.getWebpackConfig();
config.watchOptions = {
    poll: true,
};

/*config.plugins = [
    new UglifyJSPlugin()
];*/

// export the final configuration
module.exports = config;
