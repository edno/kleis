<?php
namespace Page;

class KleisPage
{
    protected $title = 'Kleis';
    protected $url = '/';
    protected $user;
    protected $tester;

    public function __construct(\AcceptanceTester $tester)
    {
        $this->tester = $tester;
        $this->tester->seeCurrentUrlEquals($this->url);
    }

    public function navigateTo(String $menu)
    {
        $this->tester->click($menu);
        $page = $this->tester->grabFromCurrentUrl('~/([A-z]*)/?.*~');
        $class = 'Page\\'.ucFirst($page).'Page';
        if (class_exists($class)) {
            return new $class($this->tester);
        } else {
            return new KleisPage($this->tester);
        }
    }

    public function logout()
    {
        $this->tester->click("Déconnexion");
        return new WelcomePage($this->tester);
    }

    public function openProfile()
    {
        return new ProfilePage($this->tester);
    }
}
