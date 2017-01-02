<?php
namespace Page\Installer;

class DatabasePage extends InstallerPage
{
    protected $step = 'Base de données';
    protected $url = '/install/database';
    protected $next = 'Customization';
    protected $back = 'Application';

    public static $objectsMap = [
        'fieldConnection' => "//select[@id=//label[text()='Connexion']/@for]",
        'fieldHost'       => "//input[@id=//label[text()='Hôte']/@for]",
        'fieldPort'       => "//input[@id=//label[text()='Port']/@for]",
        'fieldPort'       => "//input[@id=//label[text()='Port']/@for]",
        'fieldDatabase'   => "//input[@id=//label[text()='Base de données']/@for]",
        'fieldUsername'   => "//input[@id=//label[text()='Utilisateur']/@for]",
        'fieldPassword'   => "//input[@id=//label[text()='Mot de passe']/@for]",
    ];

}
