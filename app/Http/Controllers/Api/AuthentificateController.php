<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\DataTransferObject\UserDto;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Classes\Services\UserService;

class AuthentificateController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {
    }
    public function register(UserRequest $request)
    {
        $user = $this->userService->Create(UserDto::formUser($request));
        return $user;
    }

    public function login(LoginRequest $request)
    {
        $user = $this->userService->connexion($request);
        return $user;
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => true,
            "message" => "User logout Successfully"
        ], 200);
    }

    public  function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $sentPassword = $this->userService->forgotPasswordUser($request);
        return $sentPassword;
    }
}
