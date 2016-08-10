<?php

use Illuminate\Database\Seeder;
use App\Account;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'created_by' => 1,
            'group_id' => 1,
            'netlogin' => 'alidup4242',
            'netpass' => Account::generateHash('3x@mp1ePassW0r6'),
            'firstname' => 'Alice',
            'lastname' => 'Dupont',
            'expire' => date("Ymd"),
            'status' => 1
        ]);
    }
}
