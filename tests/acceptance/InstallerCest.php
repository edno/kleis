<?php

use Page\Installer\InstallerPage as Installer;

class InstallerCest
{
    public function _before(\AcceptanceTester $I)
    {
        $I->setEnvironmentVariable('kleis.installer', true);
        if (file_exists(storage_path('installed'))) {
            unlink(storage_path('installed'));
        }
        $I->seeInEnvironmentVariable('kleis.installer', true);
    }

    /**
     * @env appWeb,withRecords
     * @group installer
     */
    public function testInstall(\AcceptanceTester $I)
    {
        $I->amOnPage('/'); // redirect to installer
        $I->see('Installation de Kleis');
        $page = (new Installer($I))
                ->next() // application configuration
                ->selectLanguage('Français');
        $settings = [
            'APP_URL'    => $I->grabValueFrom($page::$objectsMap['fieldUrl']),
            'APP_LOCALE' => $I->grabValueFrom($page::$objectsMap['fieldLanguage']),
            'APP_ENV'    => $I->grabValueFrom($page::$objectsMap['fieldEnvironment'])
        ];
        $page = $page->next(); // database parameters
        $settings = array_merge($settings, [
            'DB_CONNECTION' => $I->grabValueFrom($page::$objectsMap['fieldConnection']),
            'DB_HOST'       => $I->grabValueFrom($page::$objectsMap['fieldHost']),
            'DB_PORT'       => $I->grabValueFrom($page::$objectsMap['fieldPort']),
            'DB_DATABASE'   => $I->grabValueFrom($page::$objectsMap['fieldDatabase']),
            'DB_USERNAME'   => $I->grabValueFrom($page::$objectsMap['fieldUsername']),
            'DB_PASSWORD'   => $I->grabValueFrom($page::$objectsMap['fieldPassword'])
        ]);
        $page = $page->next() // customization
                     ->next(); // environment parameters
        $fileEnv = $I->grabValueFrom($page::$objectsMap['fieldDotEnv']);
        \PHPUnit_Framework_Assert::assertArraySubset($settings, $page->getEnvironmentParameters());
        $page = $page->next() // requirements
                     ->next() // permissions
                     ->install() // final
                     ->end();
        $I->seeFileFound('installed', storage_path());
    }

    public function _after(\AcceptanceTester $I)
    {
        $I->setEnvironmentVariable('kleis.installer', false);
        copy('.env.codecept', '.env');
    }
}
