<?php

class ExportCategoriesCest
{
    protected static $command = 'php artisan export:categories';
    protected static $outPath = 'storage/app/export';
    protected static $outDir = 'categories';
    protected static $outFullPath = 'storage/app/export/categories/';

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->deleteDir(static::$outPath . '/' . static::$outDir);
        $I->seedDatabase();
    }

    protected function setData(\AcceptanceTester $I)
    {
        $cat = $I->haveInDatabase('App\Category', [
            'name' => 'Dummy',
            'icon' => 'kleis',
            'validity' => 90,
            'created_by' => 1
        ]);
        $group1  = $I->grabFromDatabase('App\Group', ['name' => 'Montreal']);
        $group2  = $I->grabFromDatabase('App\Group', ['name' => 'Kobenhavn']);
        for($i = 0; $i < 300; $i++)
        {
            $uid = uniqid('kleis');
            $I->haveInDatabase('App\Account', [
                'netlogin'    => $uid,
                'netpass'     => $uid,
                'firstname'   => $uid,
                'lastname'    => $uid,
                'category_id' => $cat->id,
                'group_id'    => ($i%2) ? $group1->id : $group2->id,
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
    public function exportCategories(\AcceptanceTester $I)
    {
        $categories = [
             ['name' => 'Tester',    'file' => 'tester.txt',    'count' => 1],
             ['name' => 'Developer', 'file' => 'developer.txt', 'count' => 0],
             ['name' => 'Dummy',     'file' => 'dummy.txt',     'count' => 100]
        ];
        $I->runShellCommand(static::$command);
        foreach($categories as $category)
        {
            $filePath = static::$outFullPath . $category['file'];
            $I->seeInShellOutput("{$category['count']} accounts '{$category['name']}' exported into file '{$filePath}'");
            $I->seeFileFound($category['file'], static::$outPath . '/' . static::$outDir);
            $I->openFile($filePath);
            $I->seeNumberNewLines($category['count'] + 1);
            $I->seeThisFileMatches("/(\w+:\w+\n){{$category['count']}}/");
            // read lines and check if each couple netlogin/netpass/active/cat_id match is a valid db record
        }
    }

    /**
     * @env appCli,noRecords
     */
    public function exportCategoriesEmpty(\AcceptanceTester $I)
    {
        $I->seeNumRecords(0, 'categories');
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("No categories to export");
        $I->dontSeeFileFound(static::$outPath . '/' . static::$outDir, static::$outPath);
    }

    /**
     * @skip Codeception charset issue
     * @env appCli,withRecords
     * @env appCli,noRecords
     */
    public function exportCategoriesWithSpecialChars(\AcceptanceTester $I)
    {
        $name =
        $category = ['name' => 'Charleville-Mézières',  'file' => 'charleville_mezieres.txt',  'count' => 0];
        $filePath = static::$outFullPath . $category['file'];
        $I->haveInDatabase('categories', [
            'name' => $category['name'],
            'icon' => 'kleis',
            'validity' => 90,
            'created_by' => 1
        ]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("{$category['count']} accounts '{$category['name']}' exported into file '{$filePath}'");
        $I->seeFileFound($category['file'], static::$outPath . '/' . static::$outDir);
    }
}
