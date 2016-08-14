<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

use WhiteHat101\Crypt\APR1_MD5;

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

    const ACCOUNT_CATEGORY = [
        0 => [  'text' => "bénéficiare en recherche d'emploi",
                'icon' => 'fa-binoculars',
                'unicon' => '&#xf1e5;'],
        1 => [  'text' => 'bénéficiare avec emploi',
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

    const ACCOUNT_SEARCH = [
        'account' => ['netlogin'],
        'fullname' => ['firstname', 'lastname'],
        'group' => [['group' => 'name']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'netlogin', 'netpass', 'expire', 'status', 'group_id', 'category', 'created_by'];

    public function creator()
    {
        return $this->hasOne('App\User', 'created_by');
    }

    public function group()
    {
        return $this->hasOne('App\Group', 'id', 'group_id');
    }

    public function getStatus()
    {
        return self::ACCOUNT_STATUS[$this->status];
    }

    public function getCategory()
    {
        return self::ACCOUNT_CATEGORY[$this->category];
    }

    public static function generateHash($password)
    {
        return APR1_MD5::hash($password);
    }

    public function enable()
    {
        $this->status = 1;
        if (empty($this->expire) || $this->expire <= date('Y-m-d')) {
            $this->expire = date_create('+90 day')->format('Y-m-d');
        }
        $this->update();
    }

    public function disable()
    {
        $this->status = 0;
        $this->update();
    }
}
