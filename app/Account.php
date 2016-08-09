<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Account extends Model
{
    const ACCOUNT_STATUS = [
        0 => [  'text' => 'inactif',
                'icon' => 'fa-ban',
                'unicon' => '&#xf05e;' ],
        1 => [  'text' => 'actif',
                'icon' => 'fa-globe',
                'unicon' => '&#xf0ac;' ]
    ];

    const ACCOUNT_EMPLOYMENT = [
        0 => [  'text' => "bénéficiare en recherche d'emploi",
                'icon' => 'fa-binoculars',
                'unicon' => '&#xf1e5;'],
        1 => [  'text' => 'bénéficiare avec recherche emploi',
                'icon' => 'fa-institution',
                'unicon' => '&#xf19c;' ],
        2 => [  'text' => 'étudiant',
                'icon' => 'fa-graduation-cap',
                'unicon' => '&#xf19d;' ],
        10 => [  'text' => 'bénévole',
                'icon' => 'fa-heart',
                'unicon' => '&#xf004;' ],
        11 => [  'text' => 'salarié',
                'icon' => 'fa-support',
                'unicon' => '&#xf1cd;' ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'netlogin', 'netpass', 'expire', 'status', 'group', 'created_by'];

    public function getCreator()
    {
        return User::findOrFail($this->created_by);
    }

    public function getStatus()
    {
        return self::ACCOUNT_STATUS[$this->status];
    }

    public function getEmployment()
    {
        return self::ACCOUNT_EMPLOYMENT[$this->employment];
    }
}
