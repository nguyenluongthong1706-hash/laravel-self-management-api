<?php
namespace App\Services;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\BusinessException;

class AuthService {
    public function __construct(private AuthRepository $authRepo){}

    public function register (array $data){
        $user = $this->authRepo->findByEmail($data['email']);

        if($user){
            throw new BusinessException("Email exists on system");
        }

        $data['password'] = Hash::make($data['password']);
        
        return $this->authRepo->store($data);
    }

    public function login(array $data){
        if(!$token = auth('api')->attempt($data)){
            throw new BusinessException("Your email or password isn't valid");
        }

        return $token;
    }
}