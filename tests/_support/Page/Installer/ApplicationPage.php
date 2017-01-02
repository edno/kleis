<?php
namespace Page\Installer;

class ApplicationPage extends InstallerPage
{
    protected $step = 'Configuration';
    protected $url = '/install/application';
    protected $next = 'Database';
    protected $back = 'Installer';

    public static $objectsMap = [
        'fieldUrl'         => "//input[@id=//label[text()='URL']/@for]",
        'fieldLanguage'    => "//select[@id=//label[text()='Langue']/@for]",
        'fieldEnvironment' => "//select[@id=//label[text()='Environnement']/@for]",
    ];

    public function selectLanguage($lang)
    {
        $this->tester->selectOption(static::$objectsMap['fieldLanguage'], $lang);
        return $this;
    }

}
