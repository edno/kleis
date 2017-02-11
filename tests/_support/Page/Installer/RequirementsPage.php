<?php
namespace Page\Installer;

class RequirementsPage extends InstallerPage
{
    protected $step = 'Prérequis';
    protected $url = '/install/requirements';
    protected $next = 'Permissions';
    protected $back = 'Environment';

}
