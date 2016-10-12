<?php

namespace Codeception\Database\Seeder;

use Illuminate\Database\Seeder;
use App\Account;
use App\Category;
use App\Group;

class AcceptanceAccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::create([
            'netlogin'    => 'test',
            'netpass'     => 'minus',
            'firstname'   => 'Minus',
            'lastname'    => 'Test',
            'category_id' => Category::where('name', '=', 'Tester')->first()->id,
            'group_id'    => Group::where('name', '=', 'Montreal')->first()->id,
            'status'      => 1,
            'expire'      => date('Y-m-d', strtotime('+10 days')),
            'created_by'  => 1,
        ]);

        Account::create([
            'netlogin'    => 'dev',
            'netpass'     => 'cortex',
            'firstname'   => 'Cortex',
            'lastname'    => 'Test',
            'category_id' => Category::where('name', '=', 'Developer')->first()->id,
            'group_id'    => Group::where('name', '=', 'Kobenhavn')->first()->id,
            'status'      => 0,
            'expire'      => date('Y-m-d', strtotime('+10 days')),
            'created_by'  => 1,
        ]);
    }
}
