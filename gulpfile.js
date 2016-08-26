var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {

    mix.less('app.less');

    mix.scripts([
        'jquery/dist/jquery.js',
        'bootstrap/dist/js/bootstrap.js',
        'bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.js',
        'bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-all.min.js'
    ], 'public/js/vendor.js', 'resources/assets/bower');

    mix.scripts([
        'copyclipboard.js',
        'kleis.js',
        'random.js',
        'string.js'
    ], 'public/js/app.js');

    mix.copy([
        'resources/assets/bower/font-awesome/fonts',
        'resources/assets/bower/lato/font',
        'resources/assets/bower/bootstrap/fonts'
    ], 'public/fonts');

    mix.copy([
        'resources/assets/css/welcome.css',
        'resources/assets/css/kleis.css'
    ], 'public/css');

    mix.copy([
        'resources/assets/bower/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css'
    ], 'public/css/vendor');
});
