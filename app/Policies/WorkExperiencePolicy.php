<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Auth\Access\Response;

class WorkExperiencePolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, WorkExperience $workExperience)
    {
        return $user->id === $workExperience->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, WorkExperience $workExperience)
    {
        return $user->id === $workExperience->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, WorkExperience $workExperience)
    {
        return $user->id === $workExperience->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}
