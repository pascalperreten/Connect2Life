<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        
    }
    
    public function view(User $authUser, Event $event) {
        return in_array($authUser->role, ['admin', 'editor', 'follow_up']) && $authUser->ministry->id === $event->ministry_id;
    } 
    public function create(User $authUser) {
            return in_array($authUser->role, ['admin', 'editor']);
    }
    public function update(User $authUser, Event $event) {
        return in_array($authUser->role, ['admin', 'editor']);
    }
    public function delete(User $authUser, Event $event) {
        return $authUser->role === 'admin';
    }
}
