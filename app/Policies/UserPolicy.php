<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $authUser) {
        return $authUser->role === 'admin';
    } 
    public function update(User $authUser, User $targetUser) {
        return in_array($authUser->role, ['admin', 'pastor', 'ambassador']);
    }
    public function delete(User $authUser, User $targetUser) {
        return $authUser->role === 'admin';
    }
    
}
