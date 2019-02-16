<?php

namespace App\Policies;

use App\User;
use App\Category;

class CategoryPolicy
{
    public function manage($user)
    {
        return $user->level >= 9;
    }

}
