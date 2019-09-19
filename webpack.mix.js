const mix = require('laravel-mix');
mix.setPublicPath('./assets');
mix.js(__dirname + '/src/Resources/assets/js/app.js', 'js/laravelplay.js')
    .sass( __dirname + '/src/Resources/assets/sass/app.scss', 'css/laravelplay.css');

if (mix.inProduction()) {
    mix.version();
}
