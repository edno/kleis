<?php

use Page\WelcomePage;

class SuperAdminCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';
    protected $name = 'Super Admin';

    public function canDisplayAdministrators(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs');
        $list = $page->getAdministratorsList();
        $I->assertContains([
                'nom' => $this->name,
                'niveau' => 'Super administrateur',
                'délégation' => '',
                'email' => $this->email,
                'actif' => 'actif'
            ],
            $list);
    }

    public function canAddNewAdministrator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs')
                ->newAdministrator()
                ->cancel();
    }

    public function canCreateAdministrator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs')
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
        $list = $page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
    }

    public function canDisableAdministrator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs')
                ->disableAdministrator('codecept@kleis.app');
        $list = $page->getAdministratorsList();
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

    public function canEnableAdministrator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs')
                ->enableAdministrator('codecept@kleis.app');
        $list = $page->getAdministratorsList();
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

    public function canEditAdministator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs');
        $list = $page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
        $page = $page->editAdministrator('codecept@kleis.app')
                ->setDetails([
                    'level' => 'Gestionnaire global',
                    'status' => 'Inactif'
                ])
                ->save();
        $list = $page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire global',
                'délégation' => '',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
    }

    public function canDeleteAdministrator(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $page = new WelcomePage($I);
        $page = $page->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Administrateurs');
        $list = $page->getAdministratorsList();
        $I->assertContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'actif'
            ],
            $list);
        $page = $page->disableAdministrator('codecept@kleis.app')
                    ->deleteAdministrator('codecept@kleis.app');
        $list = $page->getAdministratorsList();
        $I->assertNotContains([
                'nom' => 'Codecept Test',
                'niveau' => 'Gestionnaire local',
                'délégation' => 'Montreal',
                'email' => 'codecept@kleis.app',
                'actif' => 'inactif'
            ],
            $list);
    }
}
