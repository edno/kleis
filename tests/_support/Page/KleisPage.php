<?php
namespace Page;

class KleisPage
{
    protected $title = 'Kleis';
    protected $url;
    protected $user;
    protected $tester;

    public function __construct(\AcceptanceTester $tester)
    {
        $this->tester = $tester;
        if ($this->url) {
            $this->tester->seeCurrentUrlEquals($this->url);
        }
    }

    public function navigateTo($menu)
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

    public function logout($user)
    {
        $this->tester->click($user);
        $this->tester->click("Déconnexion");
        return new LoginPage($this->tester);
    }
}
