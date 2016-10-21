<?php
namespace Page;

class UserPage extends KleisPage
{
    protected $url = '/user';

    public function __construct(\AcceptanceTester $tester)
    {
        $this->tester = $tester;
        $this->tester->seeInCurrentUrl($this->url);
    }

    protected $fields = [
        'email' => "//input[@id=//label[text()='Email']/@for]",
        'password' => "//input[@id=//label[text()='Mot de passe']/@for]",
        'password2' => "//input[@id=//label[text()='Confirmation']/@for]",
        'firstname' => "//input[@id=//label[text()='Prénom']/@for]",
        'lastname' => "//input[@id=//label[text()='Nom']/@for]",
        'level' => "//select[@id=//label[text()='Niveau']/@for]",
        'group' => "//select[@id=//label[text()='Groupe']/@for]",
        'status' => "//select[@id=//label[text()='Statut']/@for]",
    ];

    public function setDetails($details)
    {
        foreach($details as $key => $value)
        {
            $field = $this->fields[$key];
            $fieldType = preg_filter('~//([a-z]+).*~', '$1', $field);
            switch ($fieldType) {
                case 'input':
                    $this->tester->fillField($field, $value);
                    break;
                case 'select':
                    $option = $this->tester->grabAttributeFrom("$field/option[contains(text(), '$value')]", 'value');
                    $this->tester->selectOption($field, $option);
                    break;
            }
        }
        return $this;
    }

    public function save()
    {
        $this->tester->click('Enregistrer');
        return new AdministratorsPage($this->tester);
        $page = $this->tester->grabFromCurrentUrl('~/([A-z]*)/?.*~');
        $class = 'Page\\'.ucFirst($page).'Page';
        return new $class($this->tester);
    }

    public function cancel()
    {
        $this->tester->click('Annuler');
        return new AdministratorsPage($this->tester);
    }

}
