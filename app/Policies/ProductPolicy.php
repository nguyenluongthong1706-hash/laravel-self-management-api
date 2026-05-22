<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, Product $product)
    {
        return $user->id === $product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}