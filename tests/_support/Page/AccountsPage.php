<?php
namespace Page;

class AccountsPage extends KleisPage
{
    protected $url = '/accounts';

    public static $objectsMap = [
        'tableItems'   => '//table',
        'buttonAdd'    => 'Créer un compte',
        'labelNew'     => 'Nouveau compte',
        'toolbarItem'  => [
            'edit' => "//td/*[text()='ACCOUNT']/ancestor::tr/descendant::a[@data-original-title='Editer']",
            'disable' => "//td/*[text()='ACCOUNT']/ancestor::tr/descendant::*[@data-original-title='Désactiver']",
            'enable' => "//td/*[text()='ACCOUNT']/ancestor::tr/descendant::a[@data-original-title='Activer']",
            'delete' => "//td/*[text()='ACCOUNT']/ancestor::tr/descendant::a[@data-original-title='Supprimer']"
        ]
    ];

    public function getAccountsList()
    {
        return $this->tester->convertHtmlTableToArray(static::$objectsMap['tableItems']);
    }

    public function newAccount()
    {
        $this->tester->click(static::$objectsMap['buttonAdd']);
        $this->tester->see(static::$objectsMap['labelNew']);
        return new AccountPage($this->tester);
    }

    public function disableAccount($email)
    {
        $button = preg_replace('/ACCOUNT/', $email, static::$objectsMap['toolbarItem']['disable']);
        $this->tester->click($button);
        return $this;
    }

    public function enableAccount($email)
    {
        $button = preg_replace('/ACCOUNT/', $email, static::$objectsMap['toolbarItem']['enable']);
        $this->tester->click($button);
        return $this;
    }

    public function deleteAccount($email)
    {
        $button = preg_replace('/ACCOUNT/', $email, static::$objectsMap['toolbarItem']['delete']);
        $this->tester->click($button);
        return $this;
    }

    public function editAccount($email)
    {
        $button = preg_replace('/ACCOUNT/', $email, static::$objectsMap['toolbarItem']['edit']);
        $this->tester->click($button);
        return new AccountPage($this->tester);
    }
}
