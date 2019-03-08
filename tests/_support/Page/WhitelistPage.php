<?php
namespace Page;

class WhitelistPage extends KleisPage
{
    protected $url = '/whitelist';

    public static $objectsMap = [
        'tableItems'   => '//table',
        'buttonAdd'    => "//button[contains(.,'Ajouter')]",
        'buttonCancel' => "//a[contains(.,'Annuler')]",
        'buttonSave'   => "//button[contains(.,'Enregistrer')]",
        'buttonDrop'   => "//a[contains(.,'Vider la liste')]",
        'fieldName'    => "//input[@id='itemname']",
        'toolbarItem'  => [
            'edit'   => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Editer']",
            'delete' => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@data-original-title='Supprimer']"
        ]
    ];

    public function getListItems()
    {
        try {
            return $this->tester->convertHtmlTableToArray(static::$objectsMap['tableItems']);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function addItem($name)
    {
        $this->tester->fillField(static::$objectsMap['fieldName'], $name);
        $this->tester->click(static::$objectsMap['buttonAdd']);
        return $this;
    }

    public function deleteItem($name)
    {
        $button = preg_replace('/ITEMNAME/', $name, static::$objectsMap['toolbarItem']['delete']);
        $this->tester->click($button);
        return $this;
    }

    public function renameItem($item, $name)
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

    public function dropItems()
    {
        $this->tester->click(static::$objectsMap['buttonDrop']);
        return $this;
    }
}
