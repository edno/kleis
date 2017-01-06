<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Proxylist View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'url'    => 'http://server/url/korrekt/und/komplett',
                        'domain' => 'domain.ext oder subdomain.domain.ext',
                        'search' => 'Wildcards * und %'
                        ],
    'domain'       => 'Domain|Domains',
    'url'          => 'URL|URLs',
    'in-whitelist' => ':Type in Whitelist',
    'actions'      => [
                        'save'   => 'Speichern',
                        'cancel' => 'Stornieren',
                        'add'    => 'Erstellen',
                        'search' => 'Suchen',
                        'drop'   => 'Leeren die Liste',
                        'edit'   => 'Bearbeiten',
                        'delete' => 'Löschen',
                        ],
    'message'       => [
                        'empty' => [
                                    'url'    => 'Keine URL',
                                    'domain' => 'Keine Domain',
                                    ],
                        'search' => '{0} Keine Ergebnisse gefunden wurde|{1} :number Ergebnisse gefunden wurde|[2,Inf] :number Ergebnissen gefunden wurden',
                        'add'    => ':Type erfolgreich geschaffen wurde.',
                        'update' => ':Type serfolgreich geaktualisiert wurde.',
                        'drop'   => "Die Liste :type geleert wurde.",
                        'delete' => ":Type ':value' gelöscht wurde.",
                        ],

];
