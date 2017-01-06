<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Accounts/Account View Language Lines
    |--------------------------------------------------------------------------
    */

    'accounts'                     => 'Konto|Konten',
    'all'                          => 'Alles',
    'email'                        => 'Email',
    'firstname'                    => 'Vorname',
    'lastname'                     => 'Zuname',
    'fullname'                     => 'Name',
    'group'                        => 'Gruppe',
    'category'                     => 'Kontenklasse',
    'expire'                       => 'Ablaufen',
    'expirydate'                   => 'Verfallsdatum',
    'status'                       => 'Status',
    'enabled'                      => 'Aktiviert',
    'disabled'                     => 'Deaktiviert',
    'password'                     => 'Passwort',
    'actions'                      => [
                                        'add'     => 'Konto erstellen',
                                        'edit'    => 'Bearbeiten',
                                        'disable' => 'Deaktivieren',
                                        'enable'  => 'Aktivieren',
                                        'delete'  => 'Löschen',
                                        'save'    => 'Speichern',
                                        'reset'   => 'Passwort',
                                        'print'   => 'Drucken',
                                        'cancel'  => 'Stornieren',
                                        'new'     => 'New account',
                                        'copy'    => 'Kopieren',
                                        'search'  => 'Suchen',
                                    ],
    'tooltip'                      => [
                                        'copy'           => 'In Zwischenablage kopieren',
                                        'copy-shortcut'  => 'Kopieren mit Ctrl-c',
                                        'copied'         => 'Kopiert',
                                        'search'         => 'Wildcards * und %',
                                        'refresh-expire' => "Verfallsdatum aktualisieren",
                                    ],
    'message'                      => [
                                        'empty'    => [
                                            'accounts'   => 'Kein Konto',
                                            'categories' => '<strong>Keine Kontenklasse verfügbar!</strong> Legen Sie bitte ein neue Kontenklasse vor Konten erstellen.',
                                            'groups'     => '<strong>Keine Kontengruppe verfügbar!</strong> Legen Sie bitte ein neue Kontengruppe vor Konten erstellen.',
                                        ],
                                        'print'    => 'Kontodetails',
                                        'password' => 'Bitte beachten Sie das Passwort oder Drucken Sie diese Seite aus vor dem Speichernn',
                                        'search'   => '{0} Kein Konto gefunden wurde|{1} :number Konto gefunden wurde|[2,Inf] :number Konten gefunden wurden',
                                        'add'      => "Konto ':account' erfolgreich geschaffen wurde.",
                                        'update'   => "Konto ':account' erfolgreich aktualisiert wurde.",
                                        'enable'   => "Konto ':account' aktiviert und endet am on :date.",
                                        'disable'  => "Konto ':account' deaktiviert.",
                                        'delete'   => "Konto ':account' gelöscht wurde.",
                                    ],
    'history'                      => 'Vorgeschichte',
    'created-by'                   => 'Erstellt von',
    'created-at'                   => 'Erstellt am',
    'updated-at'                   => 'Aktualisiert am',
    'unknown'                      => 'Unbekannte',

];
