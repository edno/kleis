<?php

namespace App\Policies;

use App\User;
use App\Account;

class AccountPolicy
{
    public function manage($user)
    {
        return $user->level >= 1;
    }

}
