<?php

use Page\LoginPage;

class ManageGroupCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';

    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->amOnPage('/');
        $this->page = new LoginPage($I);
        $this->page = $this->page
                ->login($this->email, $this->password)
                ->navigateTo('Groupes');
        $I->see('Groupes');
    }

    /**
     * @env appWeb,withRecords
     * @group admin
     * @group superadmin
     */
    public function canDisplayGroups(\AcceptanceTester $I)
    {
        $list = $this->page->getGroupsList();
        $I->assertContains([
            'groupe'       => 'Montreal',
            'comptes actifs'   => '1',
            'comptes inactifs' => '0',
            'gestionnaires'    => '1'
        ], $list);
    }

    /**
     * @env appWeb,withRecords
     * @group admin
     * @group superadmin
     * @depends canDisplayGroups
     */
    public function canAddGroup(\AcceptanceTester $I)
    {
        $this->page = $this->page->addGroup('Kleis');
        $list = $this->page->getGroupsList();
        $I->assertContains([
                'groupe'       => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
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
                'groupe'       => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $I->assertContains([
                'groupe'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group admin
     * @group superadmin
     * @depends canRenameGroup
     */
    public function canDeleteGroup(\AcceptanceTester $I)
    {
        $list = $this->page->getGroupsList();
        $I->assertContains([
                'groupe'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $this->page = $this->page->deleteGroup('Codecept');
        $list = $this->page->getGroupsList();
        $I->assertNotContains([
                'groupe'       => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'gestionnaires'    => '0'
            ],
            $list);
        $I->assertContains([
                'groupe'       => 'Montreal',
                'comptes actifs'   => '1',
                'comptes inactifs' => '0',
                'gestionnaires'    => '1'
            ], $list);
    }
}
