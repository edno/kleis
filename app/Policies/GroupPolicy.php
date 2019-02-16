<?php

namespace App\Policies;

use App\User;
use App\Group;

class GroupPolicy
{
    public function manage($user)
    {
        return $user->level >= 5;
    }

}
