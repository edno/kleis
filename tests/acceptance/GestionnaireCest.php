<?php

use Page\WelcomePage;

class GestionnaireCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';

    public function hasPermissions(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page->openApplication()
            ->login($this->email, $this->password)
            ->getPermissions();
    }

    public function canDisplayGroupAccounts(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page->openApplication()
            ->login($this->email, $this->password)
            ->navigateTo('Comptes');
    }
}
