const mix = require('laravel-mix');

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

mix.webpackConfig({
   output: {
      chunkFilename: mix.inProduction() ? "js/prod/chunks/[name]?id=[chunkhash].js" : "js/dev/chunks/[name].js"
   },
   devtool: 'source-map' // Notice this
}).sourceMaps(); // And this

mix.js('resources/js/app.js', 'public/js').vue()
    .postCss('resources/css/app.css', 'public/css', [
        //
    ]);
