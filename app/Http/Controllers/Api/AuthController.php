<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService){}

    public function register(RegisterRequest $request){
        
        $user = $this->authService->register($request->validated());

        return response()->json(['message'=>"Register successfully", 'data' =>null],200);
    }

    public function login(LoginRequest $request){
        $token = $this->authService->login($request->validated());

        $user = auth('api')->user();

        return response()->json(['message'=>"Login successfully", 'data' => new UserResource($user), 'token' => $token],200);
    }

    public function logout(){
        auth('api')->logout();

        return response()->json(['message' => 'Logged out successfully'],200);
    }
}
