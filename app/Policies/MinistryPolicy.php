<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Ministry;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MinistryPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct() {
        //
    }

    public function view(User $authUser, Ministry $ministry) {

        if ($authUser->ministry_id === $ministry->id && in_array($authUser->role, ['admin', 'editor'])) {
            return true;
        }
        return false;
        //throw new NotFoundHttpException();
    
        // /) && $authUser->ministry_id === $ministry->id;
        
    }
    public function update(User $authUser) {
        return $authUser->role === 'admin';
    }
    
    public function delete(User $authUser, Ministry $ministry) {
        return $authUser->id === $ministry->user_id;
    }
}
