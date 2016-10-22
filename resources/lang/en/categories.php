<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Categories View Language Lines
    |--------------------------------------------------------------------------
    */

    'tooltip'    => [
                    'icon'     => 'Icon',
                    'category' => 'Name of the category',
                    'search'   => 'Wildcards * and %',
                    ],
    'categories' => 'Category|Categories',
    'accounts'   => [
                    'enabled'  => 'Accounts enabled',
                    'disabled' => 'Accounts disabled',
                    ],
    'days'       => ':number day|:number days',
    'validity'   => 'Validity',
    'actions'    => [
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
    'message'    => [
                    'empty'  => 'No category',
                    'search' => '{0} No category found|{1} :number category found|[2,Inf] :number categories found',
                    'add'      => "':category' successfully created.",
                    'update'   => "':category' successfully updated.",
                    'drop'   => "Disabled accounts ':category' removed.",
                    'disable'  => "Accounts ':category' disabled.",
                    'delete'   => "':category' deleted.",
                    ],

];
