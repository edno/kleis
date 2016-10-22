<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proxylist View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'url'    => 'http://serveur/url/precise/et/complete',
                        'domain' => 'domaine.ext ou sousdomaine.domaine.ext',
                        'search' => 'Jokers * et %'
                        ],
    'domain'       => 'Domaine|Domaines',
    'url'          => 'URL|URLs',
    'in-whitelist' => ':Type en Liste Blanche',
    'actions'      => [
                        'save'   => 'Enregistrer',
                        'cancel' => 'Annuler',
                        'add'    => 'Ajouter',
                        'search' => 'Rechercher',
                        'drop'   => 'Vider la liste',
                        'edit'   => 'Editer',
                        'delete' => 'Supprimer',
                        ],
    'message'       => [
                        'empty' => [
                                    'url'    => 'Aucune URL',
                                    'domain' => 'Aucun domaine',
                                    ],
                        'search' => '{0} Aucun r&eacute;sultat trouv&eacute;e|{1} :number r&eacute;sultat trouv&eacute;|[2,Inf] :number r&eacute;sultats trouv&eacute;s',
                        'add'    => ':Type ajout&eacute; avec succ&egrave;s.',
                        'update' => ':Type mis &agrave; jour avec succ&egrave;s.',
                        'drop'   => "Liste :type a &eacute;t&eacute; vid&eacute;e.",
                        'delete' => ":Type ':value' a &eacute;t&eacute; supprim&eacute;.",
                        ],

];
