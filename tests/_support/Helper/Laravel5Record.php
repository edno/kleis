<?php
namespace Helper;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Laravel5Record extends \Codeception\Module\Laravel5
{
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
