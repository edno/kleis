<?php

namespace Codeception\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Group;

class AcceptanceGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'name' => 'Montreal',
            'created_by' => 1,
        ]);

        Group::create([
            'name' => 'Kobenhavn',
            'created_by' => 1,
        ]);
    }
}
