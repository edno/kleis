<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const USER_LEVEL_LOCAL  = 1;
    const USER_LEVEL_GLOBAL = 3;
    const USER_LEVEL_ADMIN  = 5;
    const USER_LEVEL_SUPER  = 9;

    const USER_STATUS = [
        0 => [  'text' => 'users.disabled',
                'icon' => '',
                'unicon' => '' ],
        1 => [  'text' => 'users.enabled',
                'icon' => 'fa-check',
                'unicon' => '&#xf00c;' ]
    ];

    const USER_LEVEL = [
        1 => [  'text' => 'users.access.local',
                'icon' => 'fa-support',
                'unicon' => '&#xf1cd;' ],
        3 => [  'text' => 'users.access.global',
                'icon' => 'fa-globe',
                'unicon' => '&#xf0ac;' ],
        5 => [  'text' => 'users.access.admin',
                'icon' => 'fa-shield',
                'unicon' => '&#xf132;' ],
        9 => [  'text' => 'users.access.super',
                'icon' => 'fa-rocket',
                'unicon' => '&#xf135;' ],
    ];

    const SEARCH_CRITERIA = [
        'email' => ['email'],
        'fullname' => ['firstname', 'lastname'],
        'group' => [['group' => 'name']],
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
        if (array_key_exists((int)$this->status, self::USER_STATUS)) {
            return self::USER_STATUS[(int)$this->status];
        } else {
            return null;
        }
    }

    public function getLevel()
    {
        if (array_key_exists((int)$this->level, self::USER_LEVEL)) {
            return self::USER_LEVEL[(int)$this->level];
        } else {
            return null;
        }
    }

    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'created_by');
    }

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }
}
