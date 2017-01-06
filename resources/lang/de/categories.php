<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Categories View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'    => [
                    'icon'     => 'Icon',
                    'category' => 'Kontenklassenname',
                    'search'   => 'Wildcards * and %',
                    ],
    'categories' => 'Kontenklasse|Kontenklassen',
    'accounts'   => [
                    'enabled'  => 'Aktivierten Konten',
                    'disabled' => 'Deaktivierten Konten',
                    ],
    'days'       => ':number Tag|:number Tagen',
    'validity'   => 'Gültigkeit',
    'actions'    => [
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
    'message'    => [
                    'empty'  => 'Keine Kontenklasse',
                    'search' => '{0} Keine Kontenklasse gefunden wurde|{1} :number Kontenklasse gefunden wurde|[2,Inf] :number Kontenklasses gefunden wurden',
                    'add'      => "':category' erfolgreich geschaffen wurde.",
                    'update'   => "':category' erfolgreich aktualisiert wurde.",
                    'drop'   => "Deaktivierten Konten ':category' gelöscht wurden.",
                    'disable'  => "Konten ':category' deaktiviert wurden.",
                    'delete'   => "':category' gelöscht wurde.",
                    ],

];
