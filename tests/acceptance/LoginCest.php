<?php

use Page\WelcomePage;

class LoginCest
{
    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        if (in_array('WebDriver', $scenario->current('modules'))) {
            $I->amOnPage('/');
            $this->page = new WelcomePage($I);
            $this->page = $this->page
                    ->openApplication();
        } else {
            $scenario->skip('WebDriver module not available');
        }
    }

    /**
     * @env appWeb
     * @env withRecords
     */
    public function loginWithValidCredentials(\AcceptanceTester $I)
    {
        $this->page->login('admin@kleis.app', 'admin');
        $I->see('Bienvenue Super Admin');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @depends loginWithValidCredentials
     */
    public function logout(\AcceptanceTester $I)
    {
        $this->page->login('admin@kleis.app', 'admin');
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
        $I->see('Connexion');
        $I->fillField('email', $example['login']);
        $I->fillField('password', $example['pass']);
        $I->click("//button[@type='submit']");
        $I->see($example['message']);
    }
}
