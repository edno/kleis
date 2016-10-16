<?php

namespace Codeception\Database\Seeder;

use Illuminate\Database\Seeder;
use App\User;
use App\Group;

class AcceptanceUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'Minus',
            'lastname' => 'Cortex',
            'email' => 'minus.cortex@kleis.app',
            'password' => bcrypt('cortex'),
            'level' => 1,
            'group_id' => Group::where('name', '=', 'Montreal')->first()->id,
            'created_by' => 1,
        ]);
    }
}
