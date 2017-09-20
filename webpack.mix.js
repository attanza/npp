let mix = require('laravel-mix');

mix.js('resources/assets/js/app.js', 'public/js')
.sass('resources/assets/sass/app.scss', 'public/css').version();

// mix.styles([
//     'public/css/animate.min.css',
//     'public/css/cropper.min.css'
// ], 'public/css/all.css');

if (mix.inProduction()) {
mix.version();
}
