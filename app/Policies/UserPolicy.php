<?php

namespace App\Policies;

use App\User;

class UserPolicy
{
    public function manage($user, $admin)
    {
        return $user->level >= 9;
    }

}
