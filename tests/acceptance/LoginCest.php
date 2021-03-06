<?php

use Page\LoginPage;

class LoginCest
{
    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->amOnPage('/');
        $this->page = new LoginPage($I);
    }

    /**
     * @env appWeb,withRecords
     */
    public function loginWithValidCredentials(\AcceptanceTester $I)
    {
        $this->page->login('admin@kleis.app', 'admin');
        $I->see('Bienvenue Super Admin');
    }

    /**
     * @env appWeb,withRecords
     * @depends loginWithValidCredentials
     */
    public function logout(\AcceptanceTester $I)
    {
        $this->page->login('admin@kleis.app', 'admin');
        $I->see('Bienvenue Super Admin');
        $this->page->logout('Super Admin');
        $I->dontSee('Bienvenue Super Admin');
    }

    /**
     * @env appWeb,withRecords
     * @example { "login": "invalid@gmail.com", "pass": "admin", "message": "Ces informations ne correspondent pas à nos enregistrements." }
     * @example { "login": "admin@kleis.app", "pass": "invalid", "message": "Ces informations ne correspondent pas à nos enregistrements." }
     * @example { "login": "admin@kleis.app", "pass": "", "message": "Le champ password est obligatoire." }
     * @example { "login": "", "pass": "admin", "message": "Le champ email est obligatoire." }
     * @example { "login": "", "pass": "", "message": "Le champ email est obligatoire." }
     */
    public function loginWithInvalidCredentials(AcceptanceTester $I, \Codeception\Example $example)
    {
        $I->see('Connexion');
        $I->fillField('email', $example['login']);
        $I->fillField('password', $example['pass']);
        $I->click("//button[@type='submit']");
        $I->see($example['message']);
    }
}
