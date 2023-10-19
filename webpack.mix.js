const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Sage application. By default, we are compiling the Sass file
 | for your application, as well as bundling up your JS files.
 |
 */

mix
  .setPublicPath('./public');

mix
  .js('resources/scripts/calendar.js', 'scripts');

mix
  .webpackConfig({
    'externals': {
      jquery: 'jQuery',
    },
  });

mix
  .autoload({
    jquery: ['$', 'window.jQuery']
  })
  .options({ processCssUrls: false })
  .sourceMaps(false, 'source-map')
  .version();
