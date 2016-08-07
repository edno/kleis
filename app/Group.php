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
}
