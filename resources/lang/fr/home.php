<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Welcome View Language Lines
    |--------------------------------------------------------------------------
    */

    'section'      => [
                        'permissions' => 'Bienvenue :User',
                        'info'        => 'Informations',
                        'announce'    => 'Annonce',
                      ],
    'permissions'  => [
                        'intro'       => '{1} En tant que :level de la délégation :group, vous pouvez
                                        |[2,Inf] En tant que :level, vous pouvez ',
                        'accounts'    => 'gérer les comptes utilisateurs :context',
                        'groups'      => 'gérer la liste des <strong>groupes</strong>',
                        'categories'  => 'gérer la liste des <strong>catégories</strong> utilisateur',
                        'whitelist'   => 'gérer les <strong>listes blanches</strong> internet',
                        'admin'       => 'gérer la liste des <strong>administrateurs</strong> Kleis',
                      ],
    'permissions.accounts.groups'     => "du groupe|de l'ensemble des groupes",
    'info'         => [
                        'accounts'    => 'compte|comptes',
                        'groups'      => 'groupe|groupes',
                        'items'       => 'référence|références',
                        'admin'       => 'administrateur|administrateurs',
                        'domains'     => 'domaine|domaines',
                        'urls'        => 'url|urls',
                       ],
    'info.items.whitelist'            => 'en liste blanche',
];
