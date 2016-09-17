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
                ->navigateTo('Listes Blanches\Domaines');
    }

    protected function openUrls()
    {
        $this->page = $this->page
                ->navigateTo('Listes Blanches\Urls');
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canDisplayDomainsWhitelist(\AcceptanceTester $I)
    {

        //$list = $this->page->getDomainsList();
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canDisplayUrlsWhitelist(\AcceptanceTester $I)
    {
        //$list = $this->page->getDomainsList();
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canAddDomainToWhitelist(\AcceptanceTester $I)
    {
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
    public function canUpdateDomainInWhitelist(\AcceptanceTester $I)
    {
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canUpdateUrlInWhitelist(\AcceptanceTester $I)
    {
    }

    /**
     * @group superadmin
     * @before openDomains
     */
    public function canRemovDomainFromWhitelist(\AcceptanceTester $I)
    {
    }

    /**
     * @group superadmin
     * @before openUrls
     */
    public function canRemovUrlFromWhitelist(\AcceptanceTester $I)
    {
    }
}
