<?php

use Page\WelcomePage;

class LoginCest
{
    /**
     * @env appWeb
     * @env withRecords
     */
    public function loginWithValidCredentials(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page->openApplication()
            ->login('admin@kleis.app', 'admin');
        $I->see('Bienvenue Super Admin');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @depends loginWithValidCredentials
     */
    public function logout(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login('admin@kleis.app', 'admin');
        $I->see('Bienvenue Super Admin');
        $page->logout();
        $I->dontSee('Bienvenue Super Admin');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @example { "login": "invalid@gmail.com", "pass": "admin", "message": "Ces informations ne correspondent pas à nos enregistrements." }
     * @example { "login": "admin@kleis.app", "pass": "invalid", "message": "Ces informations ne correspondent pas à nos enregistrements." }
     * @example { "login": "admin@kleis.app", "pass": "", "message": "The password field is required." }
     * @example { "login": "", "pass": "admin", "message": "The email field is required." }
     * @example { "login": "", "pass": "", "message": "The email field is required." }
     */
    public function loginWithInvalidCredentials(AcceptanceTester $I, \Codeception\Example $example)
    {
        $I->amOnPage('/');
        $I->see('Kleis');
        $I->click('Cliquer ici pour accéder à l\'application');
        $I->see('Connexion');
        $I->fillField('email', $example['login']);
        $I->fillField('password', $example['pass']);
        $I->click("//button[@type='submit']");
        $I->see($example['message']);
    }
}
