<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Users/User View Language Lines
    |--------------------------------------------------------------------------
    */

    'administrators'               => 'administrateur|administrateurs',
    'user'                         => 'Utilisateur',
    'email'                        => 'Email',
    'firstname'                    => 'Prénom',
    'lastname'                     => 'Nom',
    'fullname'                     => 'Nom',
    'group'                        => 'Groupe',
    'level'                        => 'Niveau',
    'status'                       => 'Statut',
    'enabled'                      => 'Actif',
    'disabled'                     => 'Inactif',
    'password'                     => 'Mot de passe',
    'password_confirmation'        => 'Confirmation',
    'actions'                      => [
                                        'add'     => 'Ajouter un administrateur',
                                        'edit'    => 'Editer',
                                        'disable' => 'Désactiver',
                                        'enable'  => 'Activer',
                                        'delete'  => 'Supprimer',
                                        'save'    => 'Enregistrer',
                                        'reset'   => 'Changer mot de passe',
                                        'cancel'  => 'Annuler',
                                        'new'     => 'Nouvel administrateur',
                                        'copy'    => 'Copier',
                                        'search'  => 'Rechercher',
                                    ],
    'tooltip'                      => [
                                        'copy'          => 'Copier dans le presse-papier',
                                        'copy-shortcut' => 'Copier avec Ctrl-c',
                                        'copied'        => 'Copié',
                                        'wildcards'     => 'Jokers * et %',
                                    ],
    'message'                      => [
                                        'empty'    => 'Aucun administrateur',
                                        'search'   => '{0} Aucun utilisateur trouvé|{1} :number utilisateur trouvé|[2,Inf] :number utilisateurs trouvés',
                                        'add'      => "':user' ajouté avec succès.",
                                        'update'   => "':user' mis à jour avec succès.",
                                        'enable'   => "':user' est maintenant actif.",
                                        'disable'  => "':user' a été désactivé.",
                                        'delete'   => "':user' a été supprimé.",
                                    ],
    'history'                      => 'Historique',
    'created-by'                   => 'Créer par ',
    'created-at'                   => 'Créer le ',
    'updated-at'                   => 'Mis à jour le ',
    'unknown'                      => 'inconnu',
    'access'                       => [
                                        'local'  => 'Gestionnaire local|Gestionnaires local',
                                        'global' => 'Gestionnaire global|Gestionnaires global',
                                        'admin'  => 'Administrateur|Administrateurs',
                                        'super'  => 'Super administrateur|Super administrateurs',
                                    ],

];
