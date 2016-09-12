<?php
namespace Page;

class LoginPage extends KleisPage
{
    protected $url = '/login';

    public function login($email, $password)
    {
        $this->tester->see('Connexion');
        $this->tester->fillField('email', $email);
        $this->tester->fillField('password', $password);
        $this->tester->click("//button[@type='submit']");
        return new HomePage($this->tester);
    }
}
