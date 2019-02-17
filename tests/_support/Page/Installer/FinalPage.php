<?php
namespace Page\Installer;

use Page\LoginPage;

class FinalPage extends InstallerPage
{
    protected $step = 'Terminé';
    protected $url = '/install/final';
    protected $next;
    protected $back = 'Permissions';

    public function end()
    {
        $this->tester->click('Cliquez ici pour quitter');
        return new LoginPage($this->tester);
    }

}
