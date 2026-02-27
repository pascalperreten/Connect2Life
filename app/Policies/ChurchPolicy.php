<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Church;

class ChurchPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $authUser, Church $church) {
        //dd($authUser->ministry->id, $church->event->ministry->id);
        if(in_array($authUser->role, ['admin', 'editor', 'follow_up']) && $authUser->ministry->id === $church->event->ministry->id) {
            return true;
        } 
        
        if(in_array($authUser->role, ['pastor', 'ambassador', 'church_member'])) {
            return $authUser->church_id === $church->id;
        }

        return false;
    } 

    public function create(User $authUser) {
            return in_array($authUser->role, ['admin']);
    }

    public function update(User $authUser, Church $church) {
        if(in_array($authUser->role, ['admin', 'editor'])) {
            return true;
        } 
        
        if(in_array($authUser->role, ['pastor', 'ambassador'])) {
            
            return $authUser->church_id === $church->id;
        }

        return false;
    }
    public function delete(User $authUser, Church $church) {
        return in_array($authUser->role, ['admin']) && $authUser->ministry_id = $church->event->ministry_id;
    }
}
