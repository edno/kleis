<?php
namespace Page\Installer;

class InstallerPage
{
    protected $step;
    protected $url = '/install';
    protected $tester;
    protected $next = 'Application';
    protected $back;

    public static $objectsMap = [];

    public function __construct(\AcceptanceTester $tester)
    {
        $this->tester = $tester;
        $this->tester->seeCurrentUrlEquals($this->url);
        if ($this->step) {
            $this->tester->see($this->step);
        }
    }

    public function getFieldValue($key)
    {
        $objectName = 'field'.ucfirst($key);
        return $this->tester->grabValueFrom(static::$objectsMap[$objectName]);
    }

    public function back()
    {
        $this->tester->click('Précédent');
        return $this->getClassPage($this->back);
    }

    public function next()
    {
        $this->tester->click('Suivant');
        return $this->getClassPage($this->next);
    }

    protected function getClassPage($page)
    {
        $class = "Page\\Installer\\{$page}Page";
        return new $class($this->tester);
    }
}
