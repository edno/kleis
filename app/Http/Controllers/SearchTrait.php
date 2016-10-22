<?php

namespace App\Http\Controllers;

use \ReflectionProperty;

trait SearchTrait
{

    public function search(&$entities, $type = null, $search = null)
    {
        $reflection  = new ReflectionProperty($entities, 'model');
        $reflection->setAccessible(true);
        $classname = $reflection->getValue($entities);

        $results = null;

        if (array_key_exists($type, $classname::SEARCH_CRITERIA) && !empty($search)) {
            $search = str_replace('*', '%', $search);
            $criteria = explode(' ', $search);
            $columns = $classname::SEARCH_CRITERIA[$type];

            $entities = $entities->where( function($q) use ($columns, $criteria) {
                foreach ($columns as $column) {
                    if (is_array($column)) {
                        $relation = $column;
                        foreach($relation as $table => $column) {
                            $q->whereHas($table,
                                function($query) use ($column, $criteria) {
                                    foreach($criteria as $value) {
                                        $query->orWhere($column, 'LIKE', $value);
                                    }
                                }
                            );
                        }
                    } else {
                        $q->orWhere(
                            function($query) use ($column, $criteria) {
                                foreach($criteria as $value) {
                                    $query->orWhere($column, 'LIKE', $value);
                                }
                            }
                        );
                    }
                }
            });
            $results = count($entities->get());
        }
        return $results;
    }
}
