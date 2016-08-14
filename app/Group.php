<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;

class Group extends Model
{
    const SEARCH_CRITERIA = [
        'group' => ['name'],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'created_by'];

    public function countAccounts($status = null)
    {
        $accounts = static::find($this->id)->accounts;
        if (false === is_null($status)) {
            $accounts = $accounts->where('status', $status);
        }
        return count($accounts);
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function countUsers()
    {
        $users = static::find($this->id)->users;
        return count($users);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
