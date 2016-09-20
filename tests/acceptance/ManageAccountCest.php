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

    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $this->page = new WelcomePage($I);
        $this->page = $this->page
                ->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Comptes');
    }

    /**
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     */
    public function canDisplayAccounts(\AcceptanceTester $I)
    {

        // $list = $this->page->getAccountsList();
        // $I->assertContains([
        //         'nom' => 'Gregory Heitz',
        //         'compte' => 'grehei5577',
        //         'expire' => '2016-12-08',
        //         'statut' => 'Actif'
        //     ],
        //     $list);
    }

    /**
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     */
    public function canAddNewAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAccount()
                ->cancel();
    }

    /**
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
     */
    public function canCreateAccount(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->newAccount()
                ->setDetails([
                    'firstname' => 'Codecept',
                    'lastname' => 'Kleis',
                    'category' => 'Guest',
                    'group' => 'Montreal'
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
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
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
    }

    /**
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
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
    }

    /**
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
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
     * @group localmanager
     * @group globalmanager
     * @group admin
     * @group superadmin
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
    }
}
