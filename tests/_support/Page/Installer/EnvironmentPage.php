<?php
namespace Page\Installer;

class EnvironmentPage extends InstallerPage
{
    protected $step = 'Paramètres d’environnement';
    protected $url = '/install/environment';
    protected $next = 'Requirements';
    protected $back = 'Customization';

    public static $objectsMap = [
        'fieldDotEnv' => "//textarea",
    ];

    public function getEnvironmentParameters()
    {
        $text = $this->tester->grabValueFrom(static::$objectsMap['fieldDotEnv']);
        $array = explode(PHP_EOL, $text);
        $dotEnv = [];
        foreach($array as $line) {
            $item = explode('=', $line);
            if(is_array($item) && sizeof($item) == 2) {
                $dotEnv[$item[0]] = $item[1];
            }
        }
        return $dotEnv;
    }

}
