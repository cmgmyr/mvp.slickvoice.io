var elixir = require('laravel-elixir');

var paths = {
    'bootstrap': 'vendor/bower_components/bootstrap/',
    'jquery': 'vendor/bower_components/jquery/dist/',
    'jqueryui': 'vendor/bower_components/jquery-ui/',
    'fontawesome': 'vendor/bower_components/fontawesome/'
};

elixir(function(mix) {
    mix.sass('app.scss')

    .scripts([
        paths.jquery + 'jquery.js',
        paths.jqueryui + 'jquery-ui.js',
        paths.bootstrap + 'dist/js/bootstrap.js',
        'resources/assets/js/app.js'
    ], 'public/js/app.js', './')

    .copy(paths.bootstrap + 'fonts/**', 'public/build/fonts')
    .copy(paths.fontawesome + 'fonts/**', 'public/build/fonts')
    .copy(paths.jqueryui + 'themes/base/images/**', 'public/build/css/images')

    .version(['css/app.css', 'js/app.js']);
});
