<?php

use Page\WelcomePage;

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
        if (array_key_exists('WebDriver', $scenario->current('modules'))) {
            $I->amOnPage('/');
            $this->page = new WelcomePage($I);
            $this->page = $this->page
                    ->openApplication()
                    ->login($this->email, $this->password)
                    ->navigateTo("{$this->name}/Mon compte");
        } else {
            $scenario->skip('WebDriver module not available');
        }
    }

    /**
     * @env appWeb,withRecords
     */
    public function canDisplayProfile(\AcceptanceTester $I)
    {
        $I->assertEquals($this->email, $this->page->getFieldValue('email'));
        $I->assertEquals($this->name, $this->page->getFieldValue('firstname'));
        $I->assertEquals($this->level, $this->page->getFieldValue('level'));
    }
}
