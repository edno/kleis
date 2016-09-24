<?php

class ExportGroupsCest
{
    protected static $command = 'php artisan export:groups';
    protected static $outPath = 'storage/app/export';
    protected static $outDir = 'groups';
    protected static $outFullPath = 'storage/app/export/groups/';

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        if (array_key_exists('Filesystem', $scenario->current('modules'))) {
            $I->deleteDir(static::$outPath . '/' . static::$outDir);
        } else {
            $scenario->skip('Filesystem module not available');
        }
    }

    protected function setData(\AcceptanceTester $I)
    {
        $group = 'London';
        $I->haveInDatabase('groups', ['name' => $group, 'created_by' => 1]);
        $groupId = $I->grabFromDatabase('groups',     'id', ['name' => $group]);
        $cat1Id  = $I->grabFromDatabase('categories', 'id', ['name' => 'Tester']);
        $cat2Id  = $I->grabFromDatabase('categories', 'id', ['name' => 'Developer']);
        for($i = 0; $i < 300; $i++)
        {
            $uid = uniqid('kleis');
            $I->haveInDatabase('accounts', [
                'netlogin'    => $uid,
                'netpass'     => $uid,
                'firstname'   => $uid,
                'lastname'    => $uid,
                'category_id' => ($i%2) ? $cat1Id : $cat2Id,
                'group_id'    => $groupId,
                'status'      => ($i%3) == 0,
                'expire'      => date('Y-m-d'),
                'created_by'  => 1
            ]);
        }
    }

    /**
     * @env appCli,withRecords
     * @before setData
     */
    public function exportGroups(\AcceptanceTester $I)
    {
        $groups = [
             ['name' => 'Montreal',  'file' => 'montreal.txt',  'count' => 1],
             ['name' => 'Kobenhavn', 'file' => 'kobenhavn.txt', 'count' => 0],
             ['name' => 'London',    'file' => 'london.txt',    'count' => 100]
        ];
        $I->runShellCommand(static::$command);
        foreach($groups as $group)
        {
            $filePath = static::$outFullPath . $group['file'];
            $I->seeInShellOutput("{$group['count']} accounts '{$group['name']}' exported into file '{$filePath}'");
            $I->seeFileFound($group['file'], static::$outPath . '/' . static::$outDir);
            $I->openFile($filePath);
            $I->seeNumberNewLines($group['count'] + 1);
            $I->seeThisFileMatches("/(\w+:\w+\n){{$group['count']}}/");
            // read lines and check if each couple netlogin/netpass/active/group_id match is a valid db record
        }
    }

    /**
     * @env appCli,noRecords
     */
    public function exportGroupsEmpty(\AcceptanceTester $I)
    {
        $I->seeNumRecords(0, 'groups');
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("No groups to export");
        $I->dontSeeFileFound(static::$outPath . '/' . static::$outDir, static::$outPath);
    }

    /**
     * @skip Codeception charset issue
     * @env appCli,withRecords
     * @env appCli,noRecords
     */
    public function exportGroupsWithSpecialChars(\AcceptanceTester $I)
    {
        $group = ['name' => 'Charleville-Mézières',  'file' => 'charleville_mezieres.txt',  'count' => 0];
        $filePath = static::$outFullPath . $group['file'];
        $I->haveInDatabase('groups', ['name' => $group['name'], 'created_by' => 1]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("{$group['count']} accounts '{$group['name']}' exported into file '{$filePath}'");
        $I->seeFileFound($group['file'], static::$outPath . '/' . static::$outDir);
    }
}
