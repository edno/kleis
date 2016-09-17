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
        $items = explode('/', $menu);
        foreach ($items as $item) {
            $this->tester->click($item);
        }

        $url = $this->tester->grabFromCurrentUrl('~/([A-z]+/?[A-z]*)/?.*~');
        $page = array_reduce(
            explode('/', $url),
            function($page, $item) {
                return $page . ucFirst($item);
            });
        $class = "Page\\{$page}Page";

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
