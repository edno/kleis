<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function manage($user)
    {
        return $user->level >= User::USER_LEVEL_SUPER;
    }

}
