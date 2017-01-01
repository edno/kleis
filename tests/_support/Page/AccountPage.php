<?php
namespace Page;

class AccountPage extends KleisPage
{
    protected $url = '/account';

    public static $objectsMap = [
        'fieldAccount'   => "//input[@id=//label[text()='Compte']/@for]",
        'fieldPassword'  => "//input[@id=//label[text()='Mot de passe']/@for]",
        'fieldFirstname' => "//input[@id=//label[text()='Prénom']/@for]",
        'fieldLastname'  => "//input[@id=//label[text()='Nom']/@for]",
        'fieldCategory'  => "//select[@id=//label[text()='Catégorie']/@for]",
        'fieldGroup'     => "//select[@id=//label[text()='Groupe']/@for]",
        'fieldExpire'    => "//input[@id='expirydate']",
        'fieldStatus'    => "//select[@id=//label[text()='Statut']/@for]",
        'buttonSave'     => "Enregistrer",
        'buttonCancel'   => "Annuler",
    ];

    public function __construct(\AcceptanceTester $tester)
    {
        $this->tester = $tester;
        $this->tester->seeInCurrentUrl($this->url);
    }

    public function setDetails($details)
    {
        foreach($details as $key => $value)
        {
            $fieldName = 'field'.ucfirst($key);
            $field = static::$objectsMap[$fieldName];
            $fieldType = preg_filter('~//([a-z]+).*~', '$1', $field);
            switch ($fieldType) {
                case 'input':
                    $this->tester->fillField($field, $value);
                    $this->tester->click(static::$objectsMap['fieldStatus']);
                    break;
                case 'select':
                    $option = $this->tester->grabAttributeFrom("$field/option[contains(text(), '$value')]", 'value');
                    $this->tester->selectOption($field, $option);
                    break;
            }
        }
        return $this;
    }

    public function getDetails($name)
    {
        $fieldName = 'field'.ucfirst($name);
        return $this->tester->grabValueFrom(static::$objectsMap[$fieldName]);
    }

    public function save()
    {
        $this->tester->click(static::$objectsMap['buttonSave']);
        $page = $this->tester->grabFromCurrentUrl('~/([A-z]*)/?.*~');
        $class = 'Page\\'.ucFirst($page).'Page';
        return new $class($this->tester);
    }

    public function cancel()
    {
        $this->tester->click(static::$objectsMap['buttonCancel']);
        return new AccountsPage($this->tester);
    }
}
