<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Welcome View Language Lines
    |--------------------------------------------------------------------------
    */

    'section'      => [
                        'permissions' => 'Welcom :User',
                        'info'        => 'Information',
                        'announce'    => 'Announce',
                      ],
    'permissions'  => [
                        'intro'       => '{1} As a :level for the group :group, you can
                                        |[2,Inf] As a :level, you can ',
                        'accounts'    => 'manage user accounts :context',
                        'groups'      => 'manage account <strong>groups</strong>',
                        'categories'  => 'manage account <strong>categories</strong>',
                        'whitelist'   => 'manage internet <strong>whitelists</strong>',
                        'admin'       => 'manage Kleis <strong>administrators</strong>',
                      ],
    'permissions.accounts.groups'     => "for this group|for all groups",
    'info'         => [
                        'accounts'    => 'account|accounts',
                        'groups'      => 'group|groups',
                        'items'       => 'item|items',
                        'admin'       => 'administrator|administrators',
                        'domains'     => 'domain|domains',
                        'urls'        => 'url|urls',
                       ],
    'info.items.whitelist'            => 'in white lists',
];
