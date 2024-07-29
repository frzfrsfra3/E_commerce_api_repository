<?php

namespace App\Actions;

use App\Domain\UserService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserLoginAction
{
    protected $userService;
    protected $responder;

    public function __construct(UserService $userService, JsonResponder $responder)
    {
        $this->userService = $userService;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!$token = $this->userService->login($credentials)) {
                return $this->responder->withData(['error' => 'Unauthorized'])->withStatus(401)->respond();
            }

            return $this->responder->withData(['token' => $token])->respond();
        } catch (ValidationException $e) {
            return $this->responder->withData(['errors' => $e->errors()])->withStatus(422)->respond();
        }
    }
}
