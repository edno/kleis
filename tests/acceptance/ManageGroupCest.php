<?php

use Page\WelcomePage;

class ManageGroupCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';

    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        if (array_key_exists('WebDriver', $scenario->current('modules'))) {
            $I->amOnPage('/');
            $this->page = new WelcomePage($I);
            $this->page = $this->page
                    ->openApplication()
                    ->login($this->email, $this->password)
                    ->navigateTo('Délégations');
            $I->see('Délégations');
        } else {
            $scenario->skip('WebDriver module not available');
        }
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group admin
     * @group superadmin
     */
    public function canDisplayGroups(\AcceptanceTester $I)
    {
        $list = $this->page->getGroupsList();
        $I->assertContains([
            'delegation'       => 'Montreal',
            'comptes actifs'   => '1',
            'comptes inactifs' => '0',
            'gestionnaires'    => '1'
        ], $list);
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group admin
     * @group superadmin
     * @depends canDisplayGroups
     */
    public function canAddGroup(\AcceptanceTester $I)
    {
        $this->page = $this->page->addGroup('Kleis');
        $list = $this->page->getGroupsList();
        $I->assertContains([
                'delegation'       => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group admin
     * @group superadmin
     * @depends canAddGroup
     */
    public function canRenameGroup(\AcceptanceTester $I)
    {
        $this->page = $this->page->updateGroup('Kleis', 'Codecept')
                                ->saveChanges();
        $list = $this->page->getGroupsList();
        $I->assertNotContains([
                'delegation'       => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $I->assertContains([
                'delegation'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group admin
     * @group superadmin
     * @depends canRenameGroup
     */
    public function canDeleteGroup(\AcceptanceTester $I)
    {
        $list = $this->page->getGroupsList();
        $I->assertContains([
                'delegation'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $this->page = $this->page->deleteGroup('Codecept');
        $list = $this->page->getGroupsList();
        $I->assertNotContains([
                'delegation'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $I->assertContains([
                'delegation'       => 'Montreal',
                'comptes actifs'   => '1',
                'comptes inactifs' => '0',
                'gestionnaires'    => '1'
            ], $list);
    }
}
