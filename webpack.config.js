const Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/app/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/app/build')
    .addEntry('app', './src/CongregationManager/Bundle/App/assets/app.js')
    .addEntry('public', './src/CongregationManager/Bundle/App/assets/public.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .copyFiles({
        from: './src/CongregationManager/Bundle/App/assets/images',
        to: 'images/[path][name].[hash:8].[ext]',
    })
    .copyFiles({
        from: './src/CongregationManager/Bundle/App/assets/favicon',
        to: 'favicon/[path][name].[hash:8].[ext]',
    })
;
let appConfig = Encore.getWebpackConfig();

Encore.reset();
Encore
    .setOutputPath('public/admin/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/admin/build')
    .addEntry('admin', './src/CongregationManager/Bundle/Admin/assets/admin.js')
    .splitEntryChunks()
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .copyFiles({
        from: './src/CongregationManager/Bundle/Admin/assets/images',
        to: 'images/[path][name].[hash:8].[ext]',
    })
    .copyFiles({
        from: './src/CongregationManager/Bundle/Admin/assets/favicon',
        to: 'favicon/[path][name].[hash:8].[ext]',
    })
;
let adminConfig = Encore.getWebpackConfig();

module.exports = [appConfig, adminConfig];
