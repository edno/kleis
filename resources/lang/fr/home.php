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
                      ],
    'permissions'  => [
                        'intro'       => '{1} En tant que :level de la d&eacute;l&eacute;gation :group, vous pouvez
                                        |[2,Inf] En tant que :level, vous pouvez ',
                        'accounts'    => 'G&eacute;rer les <strong>comptes</strong> utilisateurs :context',
                        'groups'      => 'G&eacute;rer la liste des <strong>groupes</strong>',
                        'categories'  => 'G&eacute;rer la liste des <strong>cat&eacute;gories</strong> utilisateur',
                        'whitelist'   => 'G&eacute;rer les <strong>listes blanches</strong> internet',
                        'admin'       => 'G&eacute;rer la liste des <strong>administrateurs</strong> Kleis',
                      ],
    'permissions.accounts.groups'     => "du groupe|de l'ensemble des groupes",
    'info'         => [
                        'accounts'    => 'compte|comptes',
                        'groups'      => 'groupe|groupes',
                        'items'       => 'r&eacute;f&eacute;rence|r&eacute;f&eacute;rences',
                        'admin'       => 'administrateur|administrateurs',
                       ],
    'info.items.whitelist'            => 'en liste blanche',
];
