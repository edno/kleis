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
        $I->haveInDatabase('proxylistitems', [
            'type' => 'domain',
            'value' => 'minus-cortex.dev',
            'created_by' => 1
        ]);
        $this->page = $this->page
                ->navigateTo('Listes Blanches/Domaines');
        $I->see('Domains en Liste Blanche');
    }

    protected function openUrls(\AcceptanceTester $I)
    {
        $I->haveInDatabase('proxylistitems', [
            'type' => 'url',
            'value' => 'https://minus.dev/cortex/test',
            'created_by' => 1
        ]);
        $this->page = $this->page
                ->navigateTo('Listes Blanches/URLs');
        $I->see('URLs en Liste Blanche');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openDomains
     */
    public function canDropDomainsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'minus-cortex.dev'
            ],
            $list);
        $this->page = $this->page->dropItems();
        $list = $this->page->getListItems();
        $I->assertEmpty($list);
        $I->see('Aucun domain.');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openUrls
     */
    public function canDropUrlsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'https://minus.dev/cortex/test'
            ],
            $list);
        $this->page = $this->page->dropItems();
        $list = $this->page->getListItems();
        $I->assertEmpty($list);
        $I->see('Aucun url.');
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openDomains
     */
    public function canDisplayDomainsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'domain' => 'minus-cortex.dev'
            ],
            $list);
    }

    /**
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openUrls
     */
    public function canDisplayUrlsWhitelist(\AcceptanceTester $I)
    {
        $list = $this->page->getListItems();
        $I->assertContains([
                'url' => 'https://minus.dev/cortex/test'
            ],
            $list);
    }

    /**
     * @env appWeb
     * @env withRecords
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
     * @env appWeb
     * @env withRecords
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
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openDomains
     * @depends canAddDomainToWhitelist
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
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openUrls
     * @depends canAddUrlToWhitelist
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
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openDomains
     * @depends canRenameDomainInWhitelist
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
     * @env appWeb
     * @env withRecords
     * @group superadmin
     * @before openUrls
     * @depends canRenameUrlInWhitelist
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
