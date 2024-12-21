<?php



namespace App\Actions;

use App\Domain\UserService;
use App\Responders\JsonResponder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserRegisterAction
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
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = $this->userService->register($data);

            return $this->responder->withData(['token' => $user['token']])->respond();
        } catch (ValidationException $e) {
            return $this->responder->withData(['errors' => $e->errors()])->withStatus(422)->respond();
        }
    }
}
