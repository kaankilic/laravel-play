const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix.js(__dirname + '/src/Resources/assets/js/app.js', 'js/laravelplay.js')
    .sass( __dirname + '/src/Resources/assets/sass/app.scss', 'css/laravelplay.css');

if (mix.inProduction()) {
    mix.version();
}
