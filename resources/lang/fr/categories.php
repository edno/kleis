<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Categories View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'    => [
                    'icon'     => 'Pictogramme',
                    'category' => 'Nom de la catégorie',
                    'search'   => 'Jokers * et %',
                    ],
    'categories' => 'Catégorie|Catégories',
    'accounts'   => [
                    'enabled'  => 'Comptes actifs',
                    'disabled' => 'Comptes inactifs',
                    ],
    'days'       => ':number jour|:number jours',
    'validity'   => 'Validité',
    'actions'    => [
                    'save'    => 'Enregistrer',
                    'cancel'  => 'Annuler',
                    'add'     => 'Ajouter',
                    'search'  => 'Rechercher',
                    'drop'    => 'Supprimer tous les comptes désactivés',
                    'edit'    => 'Editer',
                    'delete'  => 'Supprimer',
                    'display' => 'Afficher tous les comptes',
                    'disable' => 'Désactiver tous les comptes',
                    ],
    'message'    => [
                    'empty'  => 'Aucune catégorie',
                    'search' => '{0} Aucune catégorie trouvée|{1} :number catégorie trouvée|[2,Inf] :number catégories trouvées',
                    'add'      => "':category' ajoutée avec succès.",
                    'update'   => "':category' mise à jour avec succès.",
                    'drop'   => "Comptes ':category' inactifs supprimés.",
                    'disable'  => "Comptes ':category' ont été désactivés.",
                    'delete'   => "':category' a été supprimée.",
                    ],

];
