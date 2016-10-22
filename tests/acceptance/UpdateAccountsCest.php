<?php

class ExportAccountsCest
{
    protected static $command = 'php artisan update:accounts';

    protected function setData(\AcceptanceTester $I)
    {
        for($i = 0; $i < 500; $i++)
        {
            $uid = uniqid('kleis');
            $delta = '-' . rand(0, 10) . ' days';
            $I->haveInDatabase('App\Account', [
                'netlogin'    => $uid,
                'netpass'     => 'minus',
                'firstname'   => 'Minus',
                'lastname'    => 'Test',
                'category_id' => 1,
                'group_id'    => 1,
                'status'      => 1,
                'expire'      => date('Y-m-d', strtotime($delta)),
                'created_by'  => 1,
            ]);
        }
    }

    /**
     * @env appCli,withRecords
     * @before setData
     */
    public function updateAccounts(\AcceptanceTester $I)
    {
        $activeAccounts = $I->grabNumRecords(
            'accounts',
            ['expire' => ['<=', date('Y-m-d')], 'status' => '1']
        );
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeAccounts} accounts disabled");
        $I->seeNumRecords(
            0,
            'accounts',
            ['expire' => ['<=', date('Y-m-d')], 'status' => '1']
        );
    }

    /**
     * @env appCli,noRecords
     */
    public function updateAccountsEmpty(\AcceptanceTester $I)
    {
        $I->seeNumRecords(
            0,
            'accounts',
            ['expire' => ['<=', date('Y-m-d')], 'status' => '1']
        );
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("0 accounts disabled");
    }
}
