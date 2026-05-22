<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Education;
use Illuminate\Auth\Access\Response;

class EducationPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Education $education)
    {
        return $user->id === $education->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Education $education)
    {
        return $user->id === $education->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, Education $education)
    {
        return $user->id === $education->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}
