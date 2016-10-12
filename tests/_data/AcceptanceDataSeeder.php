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
        $this->call(AcceptanceGroupsSeeder::class);
        $this->call(AcceptanceCategoriesSeeder::class);
        $this->call(AcceptanceAccountsSeeder::class);
        $this->call(AcceptanceUsersSeeder::class);
    }
}
