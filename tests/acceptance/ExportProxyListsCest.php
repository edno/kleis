<?php

class ExportProxyListsCest
{
    protected static $command = 'php artisan export:whitelists --ci';
    protected static $outPath = 'storage/app/export';
    protected static $outFile = '.white.txt';
    protected static $outDir = 'proxylists';

    private $path;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $this->path = codecept_root_dir() . static::$outPath . '/' . static::$outDir;

        $I->deleteDir($this->path);
        $I->seedDatabase();
    }

    protected function setData(\AcceptanceTester $I)
    {
        $types = ['domain', 'url'];
        for($i = 0; $i < 500; $i++)
        {
            $uid = uniqid('kleis');
            $I->haveInDatabase('App\ProxyListItem', [
                'value'       => $uid,
                'type'        => $types[($i%2)] ,
                'created_by'  => 1
            ]);
        }
    }

    /**
     * @env appCli,withRecords
     * @before setData
     */
    public function exportProxyListsDomains(\AcceptanceTester $I)
    {
        $type = 'domain';
        $file = $type . static::$outFile;
        $path = $this->path .'/' . $file;
        $activeRecords = $I->grabNumRecords('App\ProxyListItem', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeRecords} ${type}s exported into file '${path}'");
        $I->seeFileFound($file, $this->path);
        $I->openFile($path);
        $I->seeNumberNewLines($activeRecords + 1);
    }

    /**
     * @env appCli,withRecords
     * @before setData
     */
    public function exportProxyListsUrls(\AcceptanceTester $I)
    {
        $type = 'url';
        $file = $type . static::$outFile;
        $path = $this->path . '/' . $file;
        $activeRecords = $I->grabNumRecords('proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeRecords} ${type}s exported into file '${path}'");
        $I->seeFileFound($file, $this->path);
        $I->openFile($path);
        $I->seeNumberNewLines($activeRecords + 1);
    }

    /**
     * @env appCli,noRecords
     */
    public function exportProxyListsEmptyDomains(\AcceptanceTester $I)
    {
        $type = 'domain';
        $file = $type . static::$outFile;
        $path = $this->path . '/' . $file;
        $I->seeNumRecords(0, 'proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("No {$type} record to export");
        $I->dontSeeFileFound($this->path, codecept_root_dir() . static::$outPath);
    }

    /**
     * @env appCli,noRecords
     */
    public function exportProxyListsEmptyUrls(\AcceptanceTester $I)
    {
        $type = 'url';
        $file = $type . static::$outFile;
        $path = $this->path . '/' . $file;
        $I->seeNumRecords(0, 'proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("No {$type} record to export");
        $I->dontSeeFileFound($this->path, codecept_root_dir() . static::$outPath);
    }
}
