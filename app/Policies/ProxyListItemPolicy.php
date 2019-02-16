<?php

namespace App\Policies;

use App\User;
use App\ProxyListItem;

class ProxyListItemPolicy
{
    public function manage($user)
    {
        return $user->level >= 1;
    }

}
