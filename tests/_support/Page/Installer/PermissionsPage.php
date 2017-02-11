<?php
namespace Page\Installer;

class PermissionsPage extends InstallerPage
{
    protected $step = 'Permissions';
    protected $url = '/install/permissions';
    protected $next = 'Final';
    protected $back = 'Requirements';

    public function install()
    {
        $this->tester->click('Installer');
        return $this->getClassPage($this->next);
    }

}
