<?php

use Page\WelcomePage;

class ManageProxyListCest
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
                ->login($this->email, $this->password);
    }

    protected function openDomains(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->navigateTo('Listes Blanches/Domaines');
        $I->see('Domains en Liste Blanche');
    }

    protected function openUrls(\AcceptanceTester $I)
    {
        $this->page = $this->page
                ->navigateTo('Listes Blanches/URLs');
        $I->see('URLs en Liste Blanche');
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canDropDomainsWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->dropItems();
        $I->see('Aucun domain.');
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canDropUrlsWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->dropItems();
        $I->see('Aucun url.');
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canDisplayDomainsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertEmpty($list);
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canDisplayUrlsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertEmpty($list);
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canAddDomainToWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->addItem('kleis.app');
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'kleis.app'
            ],
            $list);
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canAddUrlToWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->addItem('http://kleis.app/login');
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'http://kleis.app/login'
            ],
            $list);
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canRenameDomainInWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'kleis.app'
            ],
            $list);
        $this->page = $this->page
            ->renameItem('kleis.app', 'kleis.local.app')
            ->cancelChanges();
        $I->dontSeeInField($this->page::$objectsMap['fieldName'], 'kleis.local.app');
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'kleis.app'
            ],
            $list);
        $this->page = $this->page
            ->renameItem('kleis.app', 'kleis.local.app')
            ->saveChanges();
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'kleis.local.app'
            ],
            $list);
        $I->assertNotContains([
                'domain' => 'kleis.app'
            ],
            $list);
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canRenameUrlInWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'http://kleis.app/login'
            ],
            $list);
        $this->page = $this->page
            ->renameItem('http://kleis.app/login', 'http://kleis.local.app/profile')
            ->cancelChanges();
        $I->dontSeeInField($this->page::$objectsMap['fieldName'], 'http://kleis.local.app/profile');
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'http://kleis.app/login'
            ],
            $list);
        $this->page = $this->page
            ->renameItem('http://kleis.app/login', 'http://kleis.local.app/profile')
            ->saveChanges();
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'http://kleis.local.app/profile'
            ],
            $list);
        $I->assertNotContains([
                'url' => 'http://kleis.app/login'
            ],
            $list);
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canRemoveDomainFromWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->deleteItem('kleis.local.app');
        $list = $this->page->getListItems();
        $I->assertNotContains([
                'domain' => 'kleis.local.app'
            ],
            $list);
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canRemoveUrlFromWhitelist(\AcceptanceTester $I)
    {
        $this->page = $this->page->deleteItem('http://kleis.local.app/profile');
        $list = $this->page->getListItems();
        $I->assertNotContains([
                'url' => 'http://kleis.local.app/profile'
            ],
            $list);
    }
}
