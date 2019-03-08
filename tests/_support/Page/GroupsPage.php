<?php
namespace Page;

class GroupsPage extends KleisPage
{
    protected $url = '/groups';

    public static $objectsMap = [
        'tableItems'   => '//table',
        'buttonAdd'    => "//button[contains(.,'Ajouter')]",
        'buttonCancel' => "//a[contains(.,'Annuler')]",
        'buttonSave'   => "//button[contains(.,'Enregistrer')]",
        'fieldName'    => "//input[@id='groupname']",
        'toolbarItem'  => [
            'edit'    => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Editer']",
            'delete'  => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Supprimer']",
            'disable' => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Désactiver tous les comptes']",
            'drop'    => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Supprimer tous les comptes']"
        ]
    ];

    public function getGroupsList()
    {
        try {
            return $this->tester->convertHtmlTableToArray(static::$objectsMap['tableItems']);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function addGroup($name, $icon = null, $expiry = null)
    {
        $this->tester->fillField(static::$objectsMap['fieldName'], $name);
        $this->tester->click(static::$objectsMap['buttonAdd']);
        return $this;
    }

    public function deleteGroup($name)
    {
        $button = preg_replace('/ITEMNAME/', $name, static::$objectsMap['toolbarItem']['delete']);
        $this->tester->click($button);
        return $this;
    }

    public function updateGroup($item, $name)
    {
        $button = preg_replace('/ITEMNAME/', $item, static::$objectsMap['toolbarItem']['edit']);
        $this->tester->click($button);
        $this->tester->fillField(static::$objectsMap['fieldName'], $name);
        return $this;
    }

    public function saveChanges()
    {
        $this->tester->click(static::$objectsMap['buttonSave']);
        return $this;
    }

    public function cancelChanges()
    {
        $this->tester->click(static::$objectsMap['buttonCancel']);
        return $this;
    }
}
