<?php

namespace App\Policies;

use App\Models\User;

class UserManagementPolicy
{
    /**
     * Create a new policy instance.
     */
    public function manageUsers(User $user): bool
    {
        // Modify this according to your admin logic
        return true;
    }
}
