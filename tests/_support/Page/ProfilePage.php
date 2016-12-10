<?php
namespace Page;

class ProfilePage extends UserPage
{
    protected $url = '/profile';

    protected $fields = [
        'email'     => "//input[@id=//label[text()='Email']/@for]",
        'firstname' => "//input[@id=//label[text()='Prénom']/@for]",
        'lastname'  => "//input[@id=//label[text()='Nom']/@for]",
        'password'  => "//input[@id=//label[text()='Mot de passe']/@for]",
        'password2' => "//input[@id=//label[text()='Confirmation']/@for]",
        'level'     => "//input[@id=//label[text()='Niveau']/@for]",
        'group'     => "//input[@id=//label[text()='Groupe']/@for]"
    ];

    public function getFieldValue($key)
    {
        return $this->tester->grabValueFrom($this->fields[$key]);
    }

}
