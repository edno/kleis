<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Groups View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'group'    => 'Nom du groupe',
                        'search' => 'Jokers * et %'
                        ],
    'groups'       => 'Groupe|Groupes',
    'accounts'     => [
                        'enabled' => 'Comptes actifs',
                        'disabled' => 'Comptes inactifs',
                        ],
    'managers'     => 'Gestionnaires',
    'actions'      => [
                        'save'   => 'Enregistrer',
                        'cancel' => 'Annuler',
                        'add'    => 'Ajouter',
                        'search' => 'Rechercher',
                        'drop'   => 'Supprimer tous les comptes désactivés',
                        'edit'   => 'Editer',
                        'delete' => 'Supprimer',
                        'display' => 'Afficher tous les comptes',
                        'disable' => 'Désactiver tous les comptes',
                        ],
    'message'       => [
                        'empty' => 'Aucun groupe',
                        'search' => '{0} Aucun groupe trouvé|{1} :number groupe trouvé|[2,Inf] :number groupes trouvés',
                        'add'      => "':group' ajouté avec succès.",
                        'update'   => "':old' renommé en ':group'.",
                        'drop'   => "Comptes ':group' inactifs supprimés.",
                        'disable'  => "Comptes ':group' ont été désactivés.",
                        'delete'   => "':group' a été supprimé.",
                        ],

];
