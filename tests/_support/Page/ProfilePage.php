<?php
namespace Page;

class ProfilePage extends UserPage
{
    protected $url = '/profile';

    public static $objectsMap = [
        'fieldEmail'           => "//input[@id=//label[text()='Email']/@for]",
        'fieldFirstname'       => "//input[@id=//label[text()='Prénom']/@for]",
        'fieldLastname'        => "//input[@id=//label[text()='Nom']/@for]",
        'fieldPassword'        => "//input[@id=//label[text()='Mot de passe']/@for]",
        'fieldPassword2'       => "//input[@id=//label[text()='Confirmation']/@for]",
        'fieldLevel'           => "//input[@id=//label[text()='Niveau']/@for]",
        'fieldGroup'           => "//input[@id=//label[text()='Groupe']/@for]",
        'buttonSave'           => "//button[contains(.,'Enregistrer')]",
        'buttonCancel'         => "//a[contains(.,'Annuler')]",
        'buttonChangePassword' => "//a[contains(.,'Changer mot de passe')]",
    ];

    public function getFieldValue($key)
    {
        $objectName = 'field'.ucfirst($key);
        return $this->tester->grabValueFrom(static::$objectsMap[$objectName]);
    }

}
