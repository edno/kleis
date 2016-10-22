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
                      ],
    'permissions'  => [
                        'intro'       => '{1} As a :level for the group :group, you can
                                        |[2,Inf] As a :level, you can ',
                        'accounts'    => 'Manage user <strong>accounts</strong> :context',
                        'groups'      => 'Manage account <strong>groups</strong>',
                        'categories'  => 'Manage account <strong>categories</strong>',
                        'whitelist'   => 'Manage internet <strong>whitelists</strong>',
                        'admin'       => 'Manage Kleis <strong>administrators</strong>',
                      ],
    'permissions.accounts.groups'     => "for the group|for all groups",
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
