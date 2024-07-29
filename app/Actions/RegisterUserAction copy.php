<?php


namespace App\Actions;

use App\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Traits\ValidatesRequests;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    use ApiResponser, ValidatesRequests;

    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function execute(Request $request)
    {
        $this->validateRequest($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->only('name', 'email', 'password');
        $data['password'] = Hash::make($data['password']);

        $user = $this->userRepository->create($data);

        return $this->successResponse($user, 201);
    }
}
