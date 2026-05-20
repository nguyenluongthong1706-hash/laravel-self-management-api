<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
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

    public function viewAny (User $user) {
        return true;
    }

    public function view (User $user) {
        return true;
    }

    public function create (User $user) {
        return true;
    }

    public function update (User $authUser, User $targetUser) {
        return $authUser->id === $targetUser->id
        ? Response::allow()
        : Response::deny('You do not allow to implement this feature!');
    }

    public function delete (User $authUser, User $targetUser) {
        return $authUser->role === 'ADMIN'
        ? Response::allow()
        : Response::deny('You do not allow to implement this feature!');
    }
}
