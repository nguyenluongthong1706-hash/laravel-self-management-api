<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tool;
use Illuminate\Auth\Access\Response;

class ToolPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Tool $tool)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function update(User $user, Tool $tool)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, Tool $tool)
    {
        return $user->role === 'ADMIN' || $user->role === 'USER'
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}
