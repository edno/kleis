<?php

use Page\LoginPage;

class ManageCategoryCest
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
                ->navigateTo('Catégories');
        $I->see('Catégories');
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     */
    public function canDisplayCategories(\AcceptanceTester $I)
    {
        $list = $this->page->getCategoriesList();
        $I->assertContains([
                'categorie'        => 'Tester',
                'comptes actifs'   => '1',
                'comptes inactifs' => '0',
                'validite'         => '1 jour'
            ], $list
        );
        $I->assertContains([
                'categorie'        => 'Developer',
                'comptes actifs'   => '0',
                'comptes inactifs' => '1',
                'validite'         => '900 jours'
            ], $list
        );
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depens canDisplayCategories
     */
    public function canAddCategory(\AcceptanceTester $I)
    {
        $this->page = $this->page->addCategory('Kleis');
        $list = $this->page->getCategoriesList();
        $I->assertContains([
                'categorie'        => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list
        );
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depens canAddCategory
     */
    public function canRenameCategory(\AcceptanceTester $I)
    {
        $this->page = $this->page->updateCategory('Kleis', 'Codecept')
                                ->saveChanges();
        $list = $this->page->getCategoriesList();
        $I->assertNotContains([
                'categorie'        => 'Kleis',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list
        );
        $I->assertContains([
                'categorie'        => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list
        );
    }

    /**
     * @env appWeb,withRecords
     * @group superadmin
     * @depens canRenameCategory
     */
    public function canDeleteCategory(\AcceptanceTester $I)
    {
        $list = $this->page->getCategoriesList();
        $I->assertContains([
                'categorie'        => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list
        );
        $this->page = $this->page->deleteCategory('Codecept');
        $list = $this->page->getCategoriesList();
        $I->assertNotContains([
                'categorie'        => 'Codecept',
                'comptes actifs'   => '0',
                'comptes inactifs' => '0',
                'validite'         => '90 jours'
            ],
            $list
        );
        $I->assertContains([
                'categorie'        => 'Tester',
                'comptes actifs'   => '1',
                'comptes inactifs' => '0',
                'validite'         => '1 jour'
            ], $list
        );
        $I->assertContains([
                'categorie'        => 'Developer',
                'comptes actifs'   => '0',
                'comptes inactifs' => '1',
                'validite'         => '900 jours'
            ], $list
        );
    }
}
