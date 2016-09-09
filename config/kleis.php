<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kleis Proxy List Type
    |--------------------------------------------------------------------------
    |
    | This value determines the type of proxy list items that can be managed
    | within Kleis. There are 4 options for enabling/disabling each type of
    | list:
    |  - all: enable blacklist and whitelist
    |  - black: enable only blacklist
    |  - white: enable only whitelist
    |  - false: disable proxy list management
    |
    */
    'proxylist' => env('KLEIS_PROXYLIST', 'all'),
];
