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
                        'intro'       => '{1} En tant que :level de la d&eacute;l&eacute;gation :group, vous pouvez
                                        |[2,Inf] En tant que :level, vous pouvez ',
                        'accounts'    => 'g&eacute;rer les comptes utilisateurs :context',
                        'groups'      => 'g&eacute;rer la liste des <strong>groupes</strong>',
                        'categories'  => 'g&eacute;rer la liste des <strong>cat&eacute;gories</strong> utilisateur',
                        'whitelist'   => 'g&eacute;rer les <strong>listes blanches</strong> internet',
                        'admin'       => 'g&eacute;rer la liste des <strong>administrateurs</strong> Kleis',
                      ],
    'permissions.accounts.groups'     => "du groupe|de l'ensemble des groupes",
    'info'         => [
                        'accounts'    => 'compte|comptes',
                        'groups'      => 'groupe|groupes',
                        'items'       => 'r&eacute;f&eacute;rence|r&eacute;f&eacute;rences',
                        'admin'       => 'administrateur|administrateurs',
                        'domains'     => 'domaine|domaines',
                        'urls'        => 'url|urls',
                       ],
    'info.items.whitelist'            => 'en liste blanche',
];
