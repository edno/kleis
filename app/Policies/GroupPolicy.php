<?php

namespace App\Policies;

use App\User;

class GroupPolicy
{
    public function manage($user)
    {
        return $user->level >= User::USER_LEVEL_ADMIN;
    }

}
