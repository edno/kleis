<?php
namespace Helper;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Laravel5Extension extends \Codeception\Module\Laravel5
{
    // HOOK: before each suite
    public function _beforeSuite($settings = [])
    {
        require 'bootstrap/autoload.php';
        $app = require 'bootstrap/app.php';
        $app->loadEnvironmentFrom($this->config['environment_file']);
        $console = $app->make('Illuminate\Contracts\Console\Kernel');
        $console->call('migrate:refresh', ['--seed' => true]);
        codecept_debug($console->output());
        if(array_key_exists('seeders', $this->config)){
            foreach($this->config['seeders'] as $seeder) {
                codecept_debug("Seed: '$seeder'");
                $console->call('db:seed', ['--class' => $seeder]);
            }
        }
    }

    public function seeNumRecords($expect, $table, $attributes = [])
    {
        $I = $elements = $this->getModule('Asserts');
        if (class_exists($table)) {
            $I->assertEquals($count, $this->findModels($table, $attributes)->count());
        } else {
            $I->assertEquals($count, count($this->findRecords($table, $attributes)));
        }
    }

    public function grabNumRecords($table, $attributes = [])
    {
        if (class_exists($table)) {
            return $this->findModels($table, $attributes)->count();
        } else {
            return count($this->findRecords($table, $attributes));
        }
    }

    public function haveInDatabase($table, $attributes = [])
    {
        $this->haveRecord($table, $attributes = []);
    }

    public function grabFromDatabase($table, $attributes = [])
    {
        return $this->findRecord($table, $attributes = []);
    }

    protected function findModels($modelClass, $attributes = [])
    {
        $model = new $modelClass;

        if (!$model instanceof EloquentModel) {
            throw new \RuntimeException("Class $modelClass is not an Eloquent model");
        }

        $query = $model->newQuery();
        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get();
    }

    protected function findRecords($table, $attributes = [])
    {
        $query = $this->app['db']->table($table);
        foreach ($attributes as $key => $value) {
            $query->where($key, $value);
        }

        return (array) $query->get();
    }
}
