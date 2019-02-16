<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function manage($user)
    {
        return $user->level >= 9;
    }

}
