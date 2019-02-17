<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Accounts/Account View Language Lines
    |--------------------------------------------------------------------------
    */

    'accounts'                     => 'Compte|Comptes',
    'all'                          => 'Tous',
    'email'                        => 'Email',
    'firstname'                    => 'Prénom',
    'lastname'                     => 'Nom',
    'fullname'                     => 'Nom',
    'group'                        => 'Groupe',
    'category'                     => 'Catégorie',
    'expire'                       => 'Expire',
    'expirydate'                   => 'Date d\'expiration',
    'status'                       => 'Statut',
    'enabled'                      => 'Actif',
    'disabled'                     => 'Inactif',
    'password'                     => 'Mot de passe',
    'actions'                      => [
                                        'add'     => 'Créer un compte',
                                        'edit'    => 'Editer',
                                        'disable' => 'Désactiver',
                                        'enable'  => 'Activer',
                                        'delete'  => 'Supprimer',
                                        'save'    => 'Enregistrer',
                                        'reset'   => 'Mot de passe',
                                        'print'   => 'Imprimer',
                                        'cancel'  => 'Annuler',
                                        'new'     => 'Nouveau compte',
                                        'copy'    => 'Copier',
                                        'search'  => 'Rechercher',
                                    ],
    'tooltip'                      => [
                                        'copy'           => 'Copier dans le presse-papier',
                                        'copy-shortcut'  => 'Copier avec Ctrl-c',
                                        'copied'         => 'Copié',
                                        'search'         => 'Jokers * et %',
                                        'refresh-expire' => "Rafraichir la date d'expiration",
                                    ],
    'message'                      => [
                                        'empty'    => [
                                            'accounts'   => 'Aucun compte utilisateur',
                                            'categories' => '<strong>Aucune catégorie disponible !</strong> Veuillez créer une catégorie avant de continuer.',
                                            'groups'     => '<strong>Aucun groupe disponible !</strong> Veuillez créer un groupe avant de continuer.',
                                        ],
                                        'print'    => 'Information compte utilisateur',
                                        'password' => 'notez le mot de passe ou imprimer cette page avant d\'enregistrer',
                                        'search'   => '{0} Aucun compte trouvé|{1} :number compte trouvé|[2,Inf] :number comptes trouvés',
                                        'add'      => "Compte ':account' ajouté avec succès.",
                                        'update'   => "Compte ':account' mis à jour avec succès.",
                                        'enable'   => "Compte ':account' est maintenant actif et expirera le :date.",
                                        'disable'  => "Compte ':account' a été désactivé.",
                                        'delete'   => "Compte ':account' a été supprimé.",
                                    ],
    'history'                      => 'Historique',
    'created-by'                   => 'Créer par ',
    'created-at'                   => 'Créer le ',
    'updated-at'                   => 'Mis à jour le ',
    'unknown'                      => 'inconnu',

];
