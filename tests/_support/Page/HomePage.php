<?php
namespace Page;

class HomePage extends KleisPage
{
    protected $url = '/home';

    public function getPermissions()
    {
        codecept_debug(
        $this->tester->grabMultiple('//nav[contains(@id,"app-navbar")]/*/ul[contains(@class,"navbar")]/li/a')
        );
    }

    public function getInformation()
    {

    }
}
