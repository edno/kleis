<?php
namespace Page\Installer;

use Page\WelcomePage;

class FinalPage extends InstallerPage
{
    protected $step = 'Terminé';
    protected $url = '/install/final';
    protected $next;
    protected $back = 'Permissions';

    public function exit()
    {
        $this->tester->click('Cliquez ici pour quitter');
        return new WelcomePage($this->tester);
    }

}
