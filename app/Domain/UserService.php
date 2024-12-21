<?php

namespace App\Domain;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService
{
    public function register($data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        $token = JWTAuth::fromUser($user);

        return ['user' => $user, 'token' => $token];
    }
    public function login($credentials)
{
    if (!$token = JWTAuth::attempt($credentials)) {
        return false;
    }

    return $token;
}

}
