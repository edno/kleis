<?php

return [
    'version' => '1.2',

    /*
    |--------------------------------------------------------------------------
    | Legal Notice
    |--------------------------------------------------------------------------
    |
    | This value determines the "legal notice" to display on the login page
    | Set this in your ".env" file.
    |
    */
    'legal_notice' => env('KLEIS_LEGAL', ''),

    /*
    |--------------------------------------------------------------------------
    | Company Logo
    |--------------------------------------------------------------------------
    |
    | This value determines the "company logo" to display on pages
    | Set this in your ".env" file.
    |
    */
    'logo_org' => env('KLEIS_LOGO_ORG', 'null'),

    /*
    |--------------------------------------------------------------------------
    | Homepage Announce
    |--------------------------------------------------------------------------
    |
    | This value determines the "company logo" to display on pages
    | Set this in your ".env" file.
    |
    */
    'announce' => env('KLEIS_ANNOUNCE', ''),

    /*
    |--------------------------------------------------------------------------
    | Installer
    |--------------------------------------------------------------------------
    |
    | This value enable/disable the setup wizard
    | Set this in your ".env" file.
    |
    */
    'installer' => env('KLEIS_INSTALLER_ENABLED', true),
];
