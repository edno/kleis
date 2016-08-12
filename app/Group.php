<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Account;

class Group extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'created_by'];

    public function countAccounts()
    {
        $accounts = static::find($this->id)->accounts;
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
