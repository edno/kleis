<?php
// Here you can initialize variables that will be available to your tests

// $settings['modules']['enabled'][3];

require 'bootstrap/autoload.php';
$app = require 'bootstrap/app.php';
$app->loadEnvironmentFrom('.env.testing');
$app->make('Illuminate\Contracts\Console\Kernel')
    ->call('db:seed', [
        '--class' => 'Codeception\Database\Seeder\AcceptanceDataSeeder'
    ]);
