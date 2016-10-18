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

    const SEARCH_CRITERIA = [
        'account' => ['netlogin'],
        'fullname' => ['firstname', 'lastname'],
        'group' => [['group' => 'name']],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['firstname', 'lastname', 'netlogin', 'netpass', 'expire', 'status', 'group_id', 'category_id', 'created_by'];

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
        if (array_key_exists((int)$this->status, self::ACCOUNT_STATUS)) {
            return self::ACCOUNT_STATUS[(int)$this->status];
        } else {
            return null;
        }
    }

    public function category()
    {
        return $this->hasOne('App\Category', 'id', 'category_id');
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
