<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proxylist View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'url'    => 'http://server/url/accurate/and/complete',
                        'domain' => 'domain.ext or subdomain.domain.ext',
                        'search' => 'Wildcards * and %'
                        ],
    'domain'       => 'Domain|Domains',
    'url'          => 'URL|URLs',
    'in-whitelist' => ':Type in Whitelist',
    'actions'      => [
                        'save'   => 'Save',
                        'cancel' => 'Cancel',
                        'add'    => 'Add',
                        'search' => 'Search',
                        'drop'   => 'Drop list',
                        'edit'   => 'Edit',
                        'delete' => 'Delete',
                        ],
    'message'       => [
                        'empty' => [
                                    'url'    => 'No URL',
                                    'domain' => 'No domain',
                                    ],
                        'search' => '{0} No result found|{1} :number result found|[2,Inf] :number results found',
                        'add'    => ':Type successfully added.',
                        'update' => ':Type successfully updated.',
                        'drop'   => "List :type dropped.",
                        'delete' => ":Type ':value' deleted.",
                        ],

];
