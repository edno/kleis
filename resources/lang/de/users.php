<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Users/User View Language Lines
    |--------------------------------------------------------------------------
    */

    'administrators'               => 'Administrator|Administratoren',
    'user'                         => 'Benutzer',
    'email'                        => 'Email',
    'firstname'                    => 'Vorname',
    'lastname'                     => 'Zuname',
    'fullname'                     => 'Name',
    'group'                        => 'Gruppe',
    'level'                        => 'Zugriffsstufe',
    'status'                       => 'Status',
    'enabled'                      => 'Aktiviert',
    'disabled'                     => 'Deaktiviert',
    'password'                     => 'Passwort',
    'password_confirmation'        => 'Bestätigung',
    'actions'                      => [
                                        'add'     => 'Administrator erstellen',
                                        'edit'    => 'Bearbeiten',
                                        'disable' => 'Deaktivieren',
                                        'enable'  => 'Aktivieren',
                                        'delete'  => 'Löschen',
                                        'save'    => 'Speichern',
                                        'reset'   => 'Passwortänderung',
                                        'cancel'  => 'Stornieren',
                                        'new'     => 'Neue Administrator',
                                        'copy'    => 'Kopieren',
                                        'search'  => 'Suchen',
                                    ],
    'tooltip'                      => [
                                        'copy'           => 'In Zwischenablage kopieren',
                                        'copy-shortcut'  => 'Kopieren mit Ctrl-c',
                                        'copied'         => 'Kopiert',
                                        'search'         => 'Wildcards * und %',
                                    ],
    'message'                      => [
                                        'empty'    => 'Kein Administrator',
                                        'search'   => '{0} Kein Benutzer gefunden wurde|{1} :number Benutzer gefunden wurde|[2,Inf] :number Benutzer gefunden wurden',
                                        'add'      => "':user' erfolgreich geschaffen wurde.",
                                        'update'   => "':user' erfolgreich aktualisiert wurde.",
                                        'enable'   => "':user' aktiviert.",
                                        'disable'  => "':user' deaktiviert.",
                                        'delete'   => "':user' gelöscht.",
                                    ],
    'history'                      => 'Vorgeschichte',
    'created-by'                   => 'Erstellt von',
    'created-at'                   => 'Erstellt am',
    'updated-at'                   => 'Aktualisiert am',
    'unknown'                      => 'Unbekannte',
    'access'                       => [
                                        'lokal'  => 'Lokal Manager|Local Managers',
                                        'global' => 'Global Manager|Global Managers',
                                        'admin'  => 'Administrator|Administratoren',
                                        'super'  => 'Superadministrator|Superadministratoren',
                                    ],

];
