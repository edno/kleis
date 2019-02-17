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
                        'search' => '{0} Aucun résultat trouvée|{1} :number résultat trouvé|[2,Inf] :number résultats trouvés',
                        'add'    => ':Type ajouté avec succès.',
                        'update' => ':Type mis à jour avec succès.',
                        'drop'   => "Liste :type a été vidée.",
                        'delete' => ":Type ':value' a été supprimé.",
                        ],

];
