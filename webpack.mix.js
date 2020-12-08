const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
    .sourceMaps()
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .options({
        processCssUrls: false,
        postCss: [
            require('autoprefixer'),
            require('postcss-import'),
            require('tailwindcss'),
        ],
    })
    .webpackConfig(require('./webpack.config'))
    .browserSync('cratespace.test')
    .version();
