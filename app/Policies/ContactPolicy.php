<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Contact;

class ContactPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function view(User $authUser) {
        return in_array($authUser->role, ['admin', 'editor', 'follow_up']);
    } 
    public function create(User $authUser) {
        return in_array($authUser->role, ['admin', 'editor']);
    } 
    public function update(User $authUser, Contact $event) {
        return in_array($authUser->role, ['admin', 'editor', 'follow_up']);
    }
    public function delete(User $authUser, Contact $event) {
        return in_array($authUser->role, ['admin', 'editor', 'follow_up']);
    }
}
