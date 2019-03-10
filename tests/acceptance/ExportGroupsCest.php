<?php

class ExportGroupsCest
{
    protected static $command = 'php artisan export:groups --ci';
    protected static $outPath = 'storage/app/export';
    protected static $outDir = 'groups';

    private $path;
    private $filepath;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $this->path = codecept_root_dir() . static::$outPath . '/' . static::$outDir;

        $I->deleteDir($this->path);
        $I->seedDatabase();
    }

    protected function setData(\AcceptanceTester $I)
    {
        $group = $I->haveInDatabase('App\Group', ['name' => 'London', 'created_by' => 1]);
        $cat1  = $I->grabFromDatabase('App\Category', ['name' => 'Tester']);
        $cat2  = $I->grabFromDatabase('App\Category', ['name' => 'Developer']);
        for($i = 0; $i < 300; $i++)
        {
            $uid = uniqid('kleis');
            $I->haveInDatabase('App\Account', [
                'netlogin'    => $uid,
                'netpass'     => $uid,
                'firstname'   => $uid,
                'lastname'    => $uid,
                'category_id' => ($i%2) ? $cat1->id : $cat2->id,
                'group_id'    => $group->id,
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
            $filePath = $this->path . '/' . $group['file'];
            $I->seeInShellOutput("{$group['count']} accounts '{$group['name']}' exported into file '{$filePath}'");
            $I->seeFileFound($group['file'], $this->path);
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
        $I->dontSeeFileFound($this->path, codecept_root_dir() . static::$outPath);
    }

    /**
     * @env appCli,withRecords
     * @env appCli,noRecords
     */
    public function exportGroupsWithSpecialChars(\AcceptanceTester $I)
    {
        $group = ['name' => 'Charleville-Mézières',  'file' => 'charleville_mezieres.txt',  'count' => 0];
        $filePath = $this->path . '/' . $group['file'];
        $I->haveInDatabase('groups', ['name' => $group['name'], 'created_by' => 1]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("{$group['count']} accounts '{$group['name']}' exported into file '{$filePath}'");
        $I->seeFileFound($group['file'], $this->path);
    }
}
