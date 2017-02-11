<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Groups View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'group'    => 'Gruppenname',
                        'search' => 'Wildcards * und %'
                        ],
    'groups'       => 'Kontengruppe|Kontengruppen',
    'accounts'     => [
                        'enabled'  => 'Aktivierten Konten',
                        'disabled' => 'Deaktivierten Konten',
                        ],
    'managers'     => 'Managers',
    'actions'      => [
                        'save'    => 'Speichern',
                        'cancel'  => 'Stornieren',
                        'add'     => 'Erstellen',
                        'search'  => 'Suchen',
                        'drop'    => 'Löschen alle deaktivierten Konten',
                        'edit'    => 'Bearbeiten',
                        'delete'  => 'Löschen',
                        'display' => 'Konten anzeigen',
                        'disable' => 'Deaktivieren alle Konten',
                        ],
    'message'       => [
                        'empty' => 'Keine Kontengruppe',
                        'search' => '{0} Keine Kontengruppe gefunden wurde|{1} :number Kontengruppe gefunden wurde|[2,Inf] :number Kontengruppen gefunden wurden',
                        'add'      => "':group' erfolgreich geschaffen wurde.",
                        'update'   => "':group' erfolgreich aktualisiert wurde.",
                        'drop'   => "Deaktivierten Konten ':group' gelöscht wurden.",
                        'disable'  => "Konten ':group' deaktiviert wurden.",
                        'delete'   => "':group' gelöscht wurde.",
                        ],

];
