<?php
namespace Page;

class CategoriesPage extends KleisPage
{
    protected $url = '/categories';

    public static $objectsMap = [
        'tableItems'   => '//table',
        'buttonAdd'    => 'Ajouter',
        'buttonCancel' => 'Annuler',
        'buttonSave'   => 'Enregistrer',
        'buttonIcon'   => '',
        'buttonDays'   => '',
        'fieldName'    => "//input[@id='categoryname']",
        'toolbarItem'  => [
            'edit'    => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@title='Editer']",
            'delete'  => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@title='Supprimer']",
            'disable' => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@title='Désactiver tous les comptes']",
            'drop'    => "//td/*[text()='ITEMNAME']/ancestor::tr/descendant::a[@title='Supprimer tous les comptes']"
        ]
    ];

    public function getCategoriesList()
    {
        try {
            return $this->tester->convertHtmlTableToArray(static::$objectsMap['tableItems']);
        } catch (\Exception $e) {
            return [];
        }
    }

    public function addCategory($name, $icon = null, $expiry = null)
    {
        $this->tester->fillField(static::$objectsMap['fieldName'], $name);
        $this->tester->click(static::$objectsMap['buttonAdd']);
        return $this;
    }

    public function deleteCategory($name)
    {
        $button = preg_replace('/ITEMNAME/', $name, static::$objectsMap['toolbarItem']['delete']);
        $this->tester->click($button);
        return $this;
    }

    public function updateCategory($item, $name)
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
