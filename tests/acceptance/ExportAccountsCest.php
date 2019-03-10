<?php

class ExportAccountsCest
{
    protected static $command = 'php artisan export:accounts --ci';
    protected static $outPath = 'storage/app/export';
    protected static $outFile = 'accounts.txt';
    protected static $outDir = 'accounts';

    private $path;
    private $filepath;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $this->path = codecept_root_dir() . static::$outPath . '/' . static::$outDir;
        $this->filepath = $this->path . '/' . static::$outFile;

        $I->deleteDir($this->path);
        $I->seedDatabase();
    }

    /**
     * @env appCli,withRecords
     */
    public function exportAccounts(\AcceptanceTester $I)
    {
        $activeAccounts = $I->grabNumRecords('accounts', ['status' => 1]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeAccounts} accounts exported into file '" . $this->filepath . "'");
        $I->seeFileFound(static::$outFile, $this->path);
        $I->openFile($this->filepath);
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
        $I->seeInShellOutput("No accounts to export");
        $I->dontSeeFileFound($this->path, codecept_root_dir() . static::$outPath);
    }
}
