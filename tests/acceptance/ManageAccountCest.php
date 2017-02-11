<?php

use Page\WelcomePage;

class ManageAccountCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';
    protected $name = 'Super Admin';

    protected $account;
    protected $expire;

    protected $page;

    public function _before(\AcceptanceTester $I, \Codeception\Scenario $scenario)
    {
        $I->amOnPage('/');
        $this->page = new WelcomePage($I);
        $this->page = $this->page
                ->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Comptes');
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     */
    public function canDisplayAccounts(\AcceptanceTester $I)
    {

        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Minus Test',
                'compte' => 'test',
                'expire' => date('Y-m-d', strtotime('+10 days')),
                'statut' => 'Actif'
            ],
            $list);
        $I->assertContains([
                'nom' => 'Cortex Test',
                'compte' => 'dev',
                'expire' => date('Y-m-d', strtotime('-10 days')),
                'statut' => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canDisplayAccounts
     */
    public function canAddNewAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAccount()
                ->cancel();
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canAddNewAccount
     */
    public function canCreateAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAccount()
                ->setDetails([
                    'firstname' => 'Codecept',
                    'lastname'  => 'Kleis',
                    'category'  => 'Tester',
                    'group'     => 'Montreal'
                ]);
        $this->expire = $this->page->getDetails('expire');
        $this->account = $this->page->getDetails('account');
        $this->page = $this->page->save();
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Actif'
            ], $list);
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canCreateAccount
     */
    public function canDisableAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->disableAccount($this->account);
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Inactif'
            ], $list);
        $I->assertContains([
                'nom' => 'Minus Test',
                'compte' => 'test',
                'expire' => date('Y-m-d', strtotime('+10 days')),
                'statut' => 'Actif'
            ],
            $list);
        $I->assertContains([
                'nom' => 'Cortex Test',
                'compte' => 'dev',
                'expire' => date('Y-m-d', strtotime('-10 days')),
                'statut' => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canDisableAccount
     */
    public function canEnableAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->enableAccount($this->account);
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Actif'
            ], $list);
        $I->assertContains([
                'nom' => 'Minus Test',
                'compte' => 'test',
                'expire' => date('Y-m-d', strtotime('+10 days')),
                'statut' => 'Actif'
            ],
            $list);
        $I->assertContains([
                'nom' => 'Cortex Test',
                'compte' => 'dev',
                'expire' => date('Y-m-d', strtotime('-10 days')),
                'statut' => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canEnableAccount
     */
    public function canEditAccount(\AcceptanceTester $I)
    {
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Actif'
            ],
            $list);
        $this->page = $this->page->editAccount($this->account)
                ->setDetails([
                    'category'  => 'Developer',
                    'status' => 'Inactif'
                ])
                ->save();
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Inactif'
            ],
            $list);
    }

    /**
     * @env appWeb,withRecords
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     * @depends canEditAccount
     */
    public function canDeleteAccount(\AcceptanceTester $I)
    {
        $list = $this->page->getAccountsList();
        $I->assertContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Inactif'
            ], $list);
        $this->page = $this->page
            ->deleteAccount($this->account);
        $list = $this->page->getAccountsList();
        $I->assertNotContains([
                'nom' => 'Codecept Kleis',
                'compte' => $this->account,
                'expire' => $this->expire,
                'statut' => 'Inactif'
            ], $list);
        $I->assertContains([
                'nom' => 'Minus Test',
                'compte' => 'test',
                'expire' => date('Y-m-d', strtotime('+10 days')),
                'statut' => 'Actif'
            ],
            $list);
        $I->assertContains([
                'nom' => 'Cortex Test',
                'compte' => 'dev',
                'expire' => date('Y-m-d', strtotime('-10 days')),
                'statut' => 'Inactif'
            ],
            $list);
    }
}
