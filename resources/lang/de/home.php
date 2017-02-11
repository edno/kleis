<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Welcome View Language Lines
    |--------------------------------------------------------------------------
    */

    'section'      => [
                        'permissions' => 'Wilkommen :User',
                        'info'        => 'Informationen',
                        'announce'    => 'Nachricht',
                      ],
    'permissions'  => [
                        'intro'       => '{1} Als :level für die Gruppe :group, können Sie
                                        |[2,Inf] Als :level, können Sie ',
                        'accounts'    => ':context Konten zu verwalten',
                        'groups'      => '<strong>Kontengruppen</strong> zu verwalten',
                        'categories'  => '<strong>KontenKontenklassen</strong> zu verwalten',
                        'whitelist'   => '<strong>Whitelist</strong> zu verwalten',
                        'admin'       => 'Kleis <strong>Administratoren</strong> zu verwalten',
                      ],
    'permissions.accounts.groups'     => "für diese Kontengruppe|für alle Kontengruppen",
    'info'         => [
                        'accounts'    => 'Konto|Konten',
                        'groups'      => 'Kontengruppe|Kontengruppen',
                        'items'       => 'Aufzeichnung|Aufzeichnungen',
                        'admin'       => 'Administrator|Administratoren',
                        'domains'     => 'Domain|Domains',
                        'urls'        => 'URL|URLs',
                       ],
    'info.items.whitelist'            => 'in Whitelist',
];
