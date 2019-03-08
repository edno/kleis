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

    public static $objectsMap = [
        'fieldEmail'           => "//input[@id=//label[text()='Email']/@for]",
        'fieldPassword'        => "//input[@id=//label[text()='Mot de passe']/@for]",
        'fieldPassword2'       => "//input[@id=//label[text()='Confirmation']/@for]",
        'fieldFirstname'       => "//input[@id=//label[text()='Prénom']/@for]",
        'fieldLastname'        => "//input[@id=//label[text()='Nom']/@for]",
        'fieldLevel'           => "//select[@id=//label[text()='Niveau']/@for]",
        'fieldGroup'           => "//select[@id=//label[text()='Groupe']/@for]",
        'fieldStatus'          => "//select[@id=//label[text()='Statut']/@for]",
        'buttonSave'           => "//button[contains(.,'Enregistrer')]",
        'buttonCancel'         => "//a[contains(.,'Annuler')]",
        'buttonChangePassword' => "//a[contains(.,'Changer mot de passe')]",
    ];

    public function setDetails($details)
    {
        foreach($details as $key => $value)
        {
            $objectName = 'field'.ucfirst($key);
            $field = static::$objectsMap[$objectName];
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
        $this->tester->click(static::$objectsMap['buttonSave']);
        $page = $this->tester->grabFromCurrentUrl('~/([A-z]*)/?.*~');
        $class = 'Page\\'.ucFirst($page).'Page';
        return new $class($this->tester);
    }

    public function cancel()
    {
        $this->tester->click(static::$objectsMap['buttonCancel']);
        return new AdministratorsPage($this->tester);
    }

    public function changePassword($password)
    {
        $this->tester->click(static::$objectsMap['buttonChangePassword']);
        $this->tester->seeElement(static::$objectsMap['fieldPassword']);
        $this->tester->fillField(static::$objectsMap['fieldPassword'], $password);
        $this->tester->fillField(static::$objectsMap['fieldPassword2'], $password);
        return $this->save();
    }

}
