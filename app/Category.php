<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    const SEARCH_CRITERIA = [
        'category' => ['name'],
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

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

    public function creator()
    {
        return $this->hasOne('App\User', 'created_by');
    }
}
