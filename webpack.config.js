// webpack.config.js
var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/app.js and public/build/app.css
    .createSharedEntry('layout', './assets/js/layout.js')
    .addEntry('app', './assets/js/app.js')
    .addEntry('appUser', './assets/js/appUser.js')
    .addEntry('login', './assets/js/login.js')

    .enableBuildNotifications()
    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images' }
    ]))

    .cleanupOutputBeforeBuild()
    .enableVersioning()
;

// export the final configuration
module.exports = Encore.getWebpackConfig();