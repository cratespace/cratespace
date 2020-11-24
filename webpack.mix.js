const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
  .sourceMaps()
  .sass('resources/sass/app.scss', 'public/css')
  .sourceMaps()
  .options({
    processCssUrls: false,
    postCss: [require('tailwindcss')],
  })
  .browserSync('cratespace.test')
  .version();
