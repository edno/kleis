<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Groups View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'      => [
                        'group'    => 'Name of the group',
                        'search' => 'Wildcards * and %'
                        ],
    'groups'       => 'Group|Groups',
    'accounts'     => [
                        'enabled' => 'Accounts enabled',
                        'disabled' => 'Accounts disabled',
                        ],
    'managers'     => 'Managers',
    'actions'      => [
                        'save'    => 'Save',
                        'cancel'  => 'Cancel',
                        'add'     => 'Add',
                        'search'  => 'Search',
                        'drop'    => 'Remove all disabled accounts',
                        'edit'    => 'Edit',
                        'delete'  => 'Delete',
                        'display' => 'Display accounts',
                        'disable' => 'Disable all accounts',
                        ],
    'message'       => [
                        'empty' => 'No group',
                        'search' => '{0} No group found|{1} :number group found|[2,Inf] :number groups found',
                        'add'      => "':group' successfully created.",
                        'update'   => "':old' renamed to ':group'.",
                        'drop'   => "Disabled accounts ':group' removed.",
                        'disable'  => "Accounts ':group' disabled.",
                        'delete'   => "':group' deleted.",
                        ],

];
