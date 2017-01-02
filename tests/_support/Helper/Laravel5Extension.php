<?php
namespace Helper;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Laravel5Extension extends \Codeception\Module
{
    public $console;
    public $app;

    // HOOK: before each suite
    public function _beforeSuite($settings = [])
    {
        if (!defined('LARAVEL_START')) {
            require 'bootstrap/autoload.php';
        }
            $this->app = require 'bootstrap/app.php';
            $this->app->loadEnvironmentFrom($this->getModule('Laravel5')->config['environment_file']);
            $this->console = $this->app->make('Illuminate\Contracts\Console\Kernel');
            $this->seedDatabase();
    }

    public function setEnvironmentVariable($var, $value)
    {
        $this->app['config']->set($var, $value);
    }

    public function grabEnvironmentVariable($var)
    {
        return $this->app['config']->get($var);
    }

    public function seeInEnvironmentVariable($var, $expected)
    {
        $value = $this->grabEnvironmentVariable($var);
        $I = $this->getModule('Asserts');
        $I->assertEquals($expected, $value);
    }

    public function dontSeeInEnvironmentVariable($var, $expected)
    {
        $value = $this->getEnvironmentVariable($var);
        $I = $this->getModule('Asserts');
        $I->assertNotEquals($expected, $value);
    }

    public function seedDatabase()
    {
        $this->console->call('migrate:refresh', ['--seed' => true]);
        codecept_debug($this->console->output());
        if(array_key_exists('seeders', $this->config)){
            foreach($this->config['seeders'] as $seeder) {
                $this->console->call('db:seed', ['--class' => $seeder]);
                codecept_debug($this->console->output());
            }
        }
    }

    public function seeNumRecords($expect, $table, $attributes = [])
    {
        $I = $this->getModule('Asserts');
        if (class_exists($table)) {
            $I->assertEquals($expect, $this->findModels($table, $attributes)->count());
        } else {
            $I->assertEquals($expect, count($this->findRecords($table, $attributes)));
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
        return $this->getModule('Laravel5')->haveRecord($table, $attributes);
    }

    public function grabFromDatabase($table, $attributes = [])
    {
        return $this->getModule('Laravel5')->grabRecord($table, $attributes);
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
            if (is_array($value)) {
                list($constraint, $value) = $value;
                $query->where($key, $constraint, $value);
            }
            else {
                $query->where($key, $value);
            }
        }

        return (array) $query->get();
    }
}
