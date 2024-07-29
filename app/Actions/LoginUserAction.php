<?php

namespace App\Actions;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\ValidatesRequests;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginUserAction
{
    use ApiResponser, ValidatesRequests;

    public function __invoke(Request $request)
    {
        // Validate the request data
        $this->validateRequest($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');
        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->errorResponse('Invalid email or password', 401);
        }

        // Return the token
        return $this->successResponse(['token' => $token]);
    }
}
