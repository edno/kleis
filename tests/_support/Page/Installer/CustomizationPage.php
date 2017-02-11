<?php
namespace Page\Installer;

class CustomizationPage extends InstallerPage
{
    protected $step = 'Personnalisation';
    protected $url = '/install/customization';
    protected $next = 'Environment';
    protected $back = 'Database';

}
