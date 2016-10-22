<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Accounts/Account View Language Lines
    |--------------------------------------------------------------------------
    */

    'accounts'                     => 'Account|Accounts',
    'all'                          => 'All',
    'email'                        => 'Email',
    'firstname'                    => 'Firstname',
    'lastname'                     => 'Lastname',
    'fullname'                     => 'Name',
    'group'                        => 'Group',
    'category'                     => 'Category',
    'expire'                       => 'Expire',
    'expirydate'                   => 'Expiry date',
    'status'                       => 'Status',
    'enabled'                      => 'Enabled',
    'disabled'                     => 'Disabled',
    'password'                     => 'Password',
    'actions'                      => [
                                        'add'     => 'Create an account',
                                        'edit'    => 'Edit',
                                        'disable' => 'Disable',
                                        'enable'  => 'Enable',
                                        'delete'  => 'Delete',
                                        'save'    => 'Save',
                                        'reset'   => 'Password',
                                        'print'   => 'Print',
                                        'cancel'  => 'Cancel',
                                        'new'     => 'New account',
                                        'copy'    => 'Copy',
                                        'search'  => 'Search',
                                    ],
    'tooltip'                      => [
                                        'copy'          => 'Copy to clipboard',
                                        'copy-shortcut' => 'Copy with Ctrl-c',
                                        'copied'        => 'Copied',
                                        'search'        => 'Wildcards * and %',
                                    ],
    'message'                      => [
                                        'empty'    => [
                                            'accounts'   => 'No account',
                                            'categories' => '<strong>No category available!</strong> Please create a category before creating accounts.',
                                            'groups'     => '<strong>No group available!</strong> Please create a group before creating accounts.',
                                        ],
                                        'print'    => 'Account details',
                                        'password' => 'note the password or print this page before saving',
                                        'search'   => '{0} No account found|{1} :number account found|[2,Inf] :number accounts found',
                                        'add'      => "Account ':account' successfully created.",
                                        'update'   => "Account ':account' successfully updated.",
                                        'enable'   => "Account ':account' enabled and expire on :date.",
                                        'disable'  => "Account ':account' disabled.",
                                        'delete'   => "Account ':account' removed.",
                                    ],
    'history'                      => 'History',
    'created-by'                   => 'Created by',
    'created-at'                   => 'Created at',
    'updated-at'                   => 'Updated at',
    'unknown'                      => 'unknown',

];
