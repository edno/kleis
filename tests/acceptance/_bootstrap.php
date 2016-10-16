<?php
// seed database with test data

require 'bootstrap/autoload.php';
$app = require 'bootstrap/app.php';
$app->loadEnvironmentFrom('.env.codecept');
$app->make('Illuminate\Contracts\Console\Kernel')
    ->call('db:seed', [
        '--class' => 'Codeception\Database\Seeder\AcceptanceDataSeeder'
    ]);
