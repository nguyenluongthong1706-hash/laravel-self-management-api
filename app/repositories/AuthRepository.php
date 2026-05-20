<?php
namespace App\Repositories;

use App\Models\User;

class AuthRepository extends Repository{
    public function __construct (User $authModel){
        $this->model = $authModel;
    }

    public function findByEmail(string $email){
        return $user = $this->model->where('email',$email)->first();
    }
}