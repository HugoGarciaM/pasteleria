<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class RolePolicy
{
    /**
     * Create a new policy instance.
     */
    public function Role(User $user,Role $role){
        return $user->role==$role;
    }
}
