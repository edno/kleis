<?php

class ExportAccountsCest
{
    protected static $command = 'php artisan export:accounts';
    protected static $outPath = 'storage/app/export';
    protected static $outFile = 'accounts.txt';
    protected static $outDir = 'accounts';
    protected static $outFullPath = 'storage/app/export/accounts/accounts.txt';

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->deleteDir(static::$outPath . '/' . static::$outDir);
        $I->seedDatabase();
    }

    /**
     * @env appCli,withRecords
     */
    public function exportAccounts(\AcceptanceTester $I)
    {
        $activeAccounts = $I->grabNumRecords('accounts', ['status' => 1]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeAccounts} accounts exported into file '" . static::$outFullPath . "'");
        $I->seeFileFound(static::$outFile, static::$outPath . '/' . static::$outDir);
        $I->openFile(static::$outFullPath);
        $I->seeNumberNewLines($activeAccounts + 1);
        $I->seeThisFileMatches('/test:.+/');
    }

    /**
     * @env appCli,noRecords
     */
    public function exportAccountsEmpty(\AcceptanceTester $I)
    {
        $I->seeNumRecords(0, 'accounts', ['status' => 1]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("0 accounts exported into file '" . static::$outFullPath . "'");
        $I->openFile(static::$outFullPath);
        $I->seeThisFileMatches('/^$/');
    }
}
