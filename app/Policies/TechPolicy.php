<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tech;
use Illuminate\Auth\Access\Response;

class TechPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Tech $tech)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function update(User $user, Tech $tech)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, Tech $tech)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}
