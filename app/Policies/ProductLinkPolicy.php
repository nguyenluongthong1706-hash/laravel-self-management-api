<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ProductLink;
use Illuminate\Auth\Access\Response;

class ProductLinkPolicy
{
    public function view(User $user, ProductLink $productLink)
    {
        $productLink->loadMissing('product');

        return $user->id === $productLink->product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, ProductLink $productLink)
    {
        $productLink->loadMissing('product');

        return $user->id === $productLink->product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }

    public function delete(User $user, ProductLink $productLink)
    {
        $productLink->loadMissing('product');
        
        return $user->id === $productLink->product->user_id
            ? Response::allow()
            : Response::deny('You do not allow to implement this feature!');
    }
}
