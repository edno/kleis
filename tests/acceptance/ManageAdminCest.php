<?php

use Page\WelcomePage;

class ManageAdminCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';
    protected $name = 'Super Admin';

    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        if (array_key_exists('WebDriver', $scenario->current('modules'))) {
            $I->amOnPage('/');
            $this->page = new WelcomePage($I);
            $this->page = $this->page
                    ->openApplication()
                    ->login($this->email, $this->password)
                    ->navigateTo('Administrateurs');
        } else {
            $scenario->skip('WebDriver module not available');
        }
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     */
    public function canDisplayAdministrators(\AcceptanceTester $I)
    {

        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => $this->name,
                'niveau' => 'Super administrateur',
                'groupe' => '',
                'email'  => $this->email,
                'actif'  => 'Actif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     */
    public function canAddNewAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAdministrator()
                ->cancel();
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depends canAddNewAdministrator
     */
    public function canCreateAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAdministrator()
                ->setDetails([
                    'email'     => 'codecept@kleis.app',
                    'password'  => 'codecept',
                    'password2' => 'codecept',
                    'firstname' => 'Codecept',
                    'lastname'  => 'Test',
                    'level'     => 'Gestionnaire local',
                    'group'     => 'Montreal',
                    'status'    => 'Actif',
                ])
                ->save();
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'groupe' => 'Montreal',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Actif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depends canCreateAdministrator
     */
    public function canDisableAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->disableAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'groupe' => 'Montreal',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depends canDisableAdministrator
     */
    public function canEnableAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->enableAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'groupe' => 'Montreal',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Actif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depends canCreateAdministrator
     */
    public function canEditAdministrator(\AcceptanceTester $I)
    {
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'groupe' => 'Montreal',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Actif'
            ],
            $list);
        $this->page = $this->page->editAdministrator('codecept@kleis.app')
                ->setDetails([
                    'level'  => 'Gestionnaire global',
                    'status' => 'Inactif'
                ])
                ->save();
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'groupe' => '',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depends canEditAdministrator
     */
    public function canDeleteAdministrator(\AcceptanceTester $I)
    {
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'groupe' => '',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Inactif'
            ],
            $list);
        $this->page = $this->page->deleteAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        $I->assertNotContains([
                'nom'    => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'groupe' => '',
                'email'  => 'codecept@kleis.app',
                'actif'  => 'Inactif'
            ],
            $list);
    }
}
