<?php

use Page\WelcomePage;

class ManageCategoryCest
{
    protected $email = 'admin@kleis.app';
    protected $password = 'admin';

    protected $page;

    public function _before(\AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $this->page = new WelcomePage($I);
        $this->page = $this->page
                ->openApplication()
                ->login($this->email, $this->password)
                ->navigateTo('Catégories');
        $I->see('Catégories');
    }

    /**
     * @group superadmin
     */
    public function canDisplayCategories(\AcceptanceTester $I)
    {
        $list = $this->page->getCategoriesList();
        $I->assertContains([
            'categorie'        => 'Guest',
            'comptes actifs'   => '1',
            'comptes inactifs' => '0',
            'validite'         => '60 jours'
        ], $list);
    }

    /**
     * @group superadmin
     */
    public function canAddCategory(\AcceptanceTester $I)
    {
        $this->page = $this->page->addCategory('Kleis');
        $list = $this->page->getCategoriesList();
        $I->assertContains([
                'categorie' => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list);
    }
}
