<?php
namespace App\Repositories;

use App\Models\User;

class AccountRepository extends Repository{
    public function __construct(User $userModel){
        $this->model = $userModel;
    }

    public function updateOrCreate(string $user_id, array $data){
        return $this->model->updateOrCreate(
            ['user_id' => $user_id],
            $data
        );
    }
}