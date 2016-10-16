<?php
namespace Page;

class AdministratorsPage extends KleisPage
{
    protected $url = '/administrators';
    protected $toolbar = [
        'edit' => "//td/*[text()='USEREMAIL']/ancestor::tr/descendant::a[@data-original-title='Editer']",
        'disable' => "//td/*[text()='USEREMAIL']/ancestor::tr/descendant::*[@data-original-title='Désactiver']",
        'enable' => "//td/*[text()='USEREMAIL']/ancestor::tr/descendant::a[@data-original-title='Activer']",
        'delete' => "//td/*[text()='USEREMAIL']/ancestor::tr/descendant::a[@data-original-title='Supprimer']"
    ];

    public function getAdministratorsList()
    {
        $data = $this->tester->convertHtmlTableToArray('//table');
        // hack for removing '●' that signify 'none' in GUI
        array_walk($data, function(&$row) {
            array_walk($row, function(&$item) {
                $item = str_replace('●', '', $item);
            });
        });
        return $data;
    }

    public function newAdministrator()
    {
        $this->tester->click("Ajouter un administrateur");
        $this->tester->see('Nouvel administrateur');
        return new UserPage($this->tester);
    }

    public function disableAdministrator($email)
    {
        $button = preg_replace('/USEREMAIL/', $email, $this->toolbar['disable']);
        $this->tester->click($button);
        return $this;
    }

    public function enableAdministrator($email)
    {
        $button = preg_replace('/USEREMAIL/', $email, $this->toolbar['enable']);
        $this->tester->click($button);
        return $this;
    }

    public function deleteAdministrator($email)
    {
        $button = preg_replace('/USEREMAIL/', $email, $this->toolbar['delete']);
        $this->tester->click($button);
        return $this;
    }

    public function editAdministrator($email)
    {
        $button = preg_replace('/USEREMAIL/', $email, $this->toolbar['edit']);
        $this->tester->click($button);
        return new UserPage($this->tester);
    }
}
