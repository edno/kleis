<?php

class ExportProxyListsCest
{
    protected static $command = 'php artisan export:whitelists';
    protected static $outPath = 'storage/app/export';
    protected static $outFile = '.white.txt';
    protected static $outDir = 'proxylists';
    protected static $outFullPath = 'storage/app/export/proxylists/';

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        if (array_key_exists('Filesystem', $scenario->current('modules'))) {
            $I->deleteDir(static::$outPath . '/' . static::$outDir);
            $I->seedDatabase();
        } else {
            $scenario->skip('Filesystem module not available');
        }
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
        $path = static::$outFullPath . $file;
        $activeRecords = $I->grabNumRecords('App\ProxyListItem', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeRecords} ${type}s exported into file '${path}'");
        $I->seeFileFound($file, static::$outPath . '/' . static::$outDir);
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
        $path = static::$outFullPath . $file;
        $activeRecords = $I->grabNumRecords('proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("${activeRecords} ${type}s exported into file '${path}'");
        $I->seeFileFound($file, static::$outPath . '/' . static::$outDir);
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
        $path = static::$outFullPath . $file;
        $I->seeNumRecords(0, 'proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("0 ${type}s exported into file '${path}'");
        $I->openFile($path);
        $I->seeThisFileMatches('/^$/');
    }

    /**
     * @env appCli,noRecords
     */
    public function exportProxyListsEmptyUrls(\AcceptanceTester $I)
    {
        $type = 'url';
        $file = $type . static::$outFile;
        $path = static::$outFullPath . $file;
        $I->seeNumRecords(0, 'proxylistitems', ['type' => $type]);
        $I->runShellCommand(static::$command);
        $I->seeInShellOutput("0 ${type}s exported into file '${path}'");
        $I->openFile($path);
        $I->seeThisFileMatches('/^$/');
    }
}
