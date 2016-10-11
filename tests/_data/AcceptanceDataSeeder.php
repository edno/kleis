<?php

namespace Codeception\Database\Seeder;

use Illuminate\Database\Seeder;
use App\User;

class AcceptanceDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'Super Admin',
            'lastname' => '',
            'email' => 'admin@kleis.app',
            'password' => bcrypt('admin'),
            'level' => 9,
            'group_id' => 0,
            'created_by' => 1,
        ]);
    }
}
