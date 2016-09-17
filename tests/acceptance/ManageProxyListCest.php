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

    protected function openDomains()
    {
        $this->page = $this->page
                ->navigateTo('Listes Blanches/Domaines');
    }

    protected function openUrls()
    {
        $this->page = $this->page
                ->navigateTo('Listes Blanches/URLs');
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
    public function canAddUrloWhitelist(\AcceptanceTester $I)
    {
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
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'kleis.app'
            ],
            $list);
        $this->page = $this->page
            ->renameItem('kleis.app', 'kleis.local.app')
            ->saveChanges();
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
    }
}
