<?php

namespace App\Policies;

use App\User;

class AccountPolicy
{
    public function manage($user)
    {
        return $user->level >= User::USER_LEVEL_LOCAL;
    }

}
