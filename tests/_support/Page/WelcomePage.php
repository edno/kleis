<?php
namespace Page;

class WelcomePage extends KleisPage
{
    public function openApplication()
    {
        $this->tester->click('Cliquer ici pour accéder à l\'application');
        return new LoginPage($this->tester);
    }
}
