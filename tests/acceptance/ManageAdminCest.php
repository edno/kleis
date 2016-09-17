<?php

use Page\WelcomePage;

class ManageAdminCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';
    protected $name = 'Super Admin';

    protected $page;

    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $this->page = new WelcomePage($I);
        $this->page = $this->page
                ->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs');
    }

    /**
     * @group superadmin
     */
    public function canDisplayAdministrators(\AcceptanceTester $I)
    {

        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom' => $this->name,
                'niveau' => 'Super administrateur',
                'délégation' => '',
                'email' => $this->email,
                'actif' => 'actif'
            ],
            $list);
    }

    /**
     * @group superadmin
     */
    public function canAddNewAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAdministrator()
                ->cancel();
    }

    /**
     * @group superadmin
     */
    public function canCreateAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAdministrator()
                ->setDetails([
                    'email' => 'codecept@kleis.app',
                    'password' => 'codecept',
                    'password2' => 'codecept',
                    'firstname' => 'Codecept',
                    'lastname' => 'Test',
                    'level' => 'Gestionnaire local',
                    'group' => 'Montreal',
                    'status' => 'Actif',
                ])
                ->save();
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
    }

    /**
     * @group superadmin
     */
    public function canDisableAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->disableAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        codecept_debug($list);
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
    }

    /**
     * @group superadmin
     */
    public function canEnableAdministrator(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->enableAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        codecept_debug($list);
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
    }

    /**
     * @group superadmin
     */
    public function canEditAdministator(\AcceptanceTester $I)
    {
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
        $this->page = $this->page->editAdministrator('codecept@kleis.app')
                ->setDetails([
                    'level' => 'Gestionnaire global',
                    'status' => 'Inactif'
                ])
                ->save();
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'délégation' => '',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
    }

    /**
     * @group superadmin
     */
    public function canDeleteAdministrator(\AcceptanceTester $I)
    {
        $list = $this->page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'délégation' => '',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
        $this->page = $this->page->deleteAdministrator('codecept@kleis.app');
        $list = $this->page->getAdministratorsList();
        $I->assertNotContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'délégation' => '',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
    }
}
