<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USER_STATUS = [
        0 => [  'text' => 'inactif',
                'icon' => '',
                'unicon' => '' ],
        1 => [  'text' => 'actif',
                'icon' => 'fa-check',
                'unicon' => '&#xf00c;' ]
    ];

    const USER_LEVEL = [
        1 => [  'text' => 'gestionnaire',
                'icon' => 'fa-support',
                'unicon' => '&#xf1cd;' ],
        2 => [  'text' => 'administrateur',
                'icon' => 'fa-shield',
                'unicon' => '&#xf132;' ],
        9 => [  'text' => 'super administrateur',
                'icon' => 'fa-rocket',
                'unicon' => '&#xf135;' ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getStatus()
    {
        return self::USER_STATUS[$this->status];
    }

    public function getLevel()
    {
        return self::USER_LEVEL[$this->level];
    }

    public function getCreator()
    {
        return User::findOrFail($this->created_by);
    }

    public function getGroup()
    {
        return Group::findOrFail($this->group_id);
    }
}
