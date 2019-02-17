<?php

use Page\LoginPage;

class ManageProfileCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';
    protected $name = 'Super Admin';
    protected $level = 'Super administrateur';

    protected $account;
    protected $expire;

    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->amOnPage('/');
        $this->page = new LoginPage($I);
        $this->page = $this->page
                ->login($this->email, $this->password);
    }

    /**
     * @env appWeb,withRecords
     */
    public function canDisplayProfile(\AcceptanceTester $I)
    {
        $this->page = $this->page->navigateTo("{$this->name}/Mon compte");
        $I->assertEquals($this->email, $this->page->getFieldValue('email'));
        $I->assertEquals($this->name, $this->page->getFieldValue('firstname'));
        $I->assertEquals($this->level, $this->page->getFieldValue('level'));
    }

    /**
     * @env appWeb,withRecords
     * @after canDisplayProfile
     */
    public function canUpdatePassword(\AcceptanceTester $I)
    {
        $newPassword = 'canUpdatePassword';

        $this->page = $this->page
                ->navigateTo("{$this->name}/Mon compte")
                ->changePassword($newPassword);
        $I->see("'{$this->email}' mis à jour avec succès.");
        $this->page
                ->logout('Super Admin')
                ->login($this->email, $newPassword)
                ->navigateTo("{$this->name}/Mon compte");
    }

    public function _after(\AcceptanceTester $I)
    {
        $I->seedDatabase(); // reset default password
    }
}
