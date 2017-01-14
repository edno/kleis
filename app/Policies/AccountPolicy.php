<?php

namespace App\Policies;

use App\User;
use App\Account;

class AccountPolicy
{
    public function manage($user, $account)
    {
        return $user->level >= 1;
    }

}
