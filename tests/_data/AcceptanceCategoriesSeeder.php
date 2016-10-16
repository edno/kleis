<?php

namespace Codeception\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Category;

class AcceptanceCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Tester',
            'icon' => 'fa-flask',
            'validity' => 1,
            'created_by' => 1,
        ]);

        Category::create([
            'name' => 'Developer',
            'icon' => 'fa-gear',
            'validity' => 900,
            'created_by' => 1,
        ]);
    }
}
