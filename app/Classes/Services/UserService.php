<?php

namespace App\Classes\Services;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\classes\Decript;
use Illuminate\Http\Request;
use App\Jobs\ResetPasswordJob;
use Illuminate\Support\Facades\DB;
use App\DataTransferObject\UserDto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObject\UserLoginDto;

class UserService
{

    public function Index()
    {
        $users = User::orderBy('id', 'desc')->all();
        return $users;
    }

    public function Create(UserDto $userDto)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                "firstName"      => $userDto->firstName,
                "lastName"      => $userDto->lastName,
                "email"     => $userDto->email,
                "phone" => $userDto->phone,
                "password"  => Hash::make($userDto->password),
            ]);
            $token = $user->createToken("authorToken")->plainTextToken;
            DB::commit();
            return response()->json([
                "status" => true,
                "message" => "User Registered Successfully.",
                "data" => $user,
                "token" => $token,
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return [
                $e->getMessage(),
                $e->getLine(),
                $e->getFile()
            ];
        }
    }

    public function connexion(Request $request)
    {
        $user = User::where('email', $request['email'])
            ->orWhere('phone', $request['email'])
            ->first();
        if ($user != null) {
            if (!Auth::attempt(["email" => $request["email"], "password" => $request["password"]])) {
                $error = "These credentials do not match our records.";
                return response()->json([
                    "status" => false,
                    "code" => 401,
                    "message" => $error,
                ], 401);
            } else {
                $token = $user->createToken("authorToken")->plainTextToken;
                return response()->json([
                    "status" => true,
                    "message" => "User logged Successfully.",
                    "data" => Auth::user(),
                    "token" => $token
                ], 200);
            }
        } else {
            return response()->json([
                "status" => false,
                "code" => 401,
                "message" => "Your email or phone number does not exist.",
            ], 401);
        }
    }

    public function forgotPasswordUser(Request $request)
    {
        //   $request->validate([
        //     'email' => 'required|email',
        //   ]);
        $decri = new Decript;
        $token = $decri->Encrypt($request->email);
        $user = User::where("email", $request->email)->first();
        if ($user == null) {
            return response()->json([
                "status" => false,
                "message" => "email does not exist"
            ], 402);
        }
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $email = [$user->email];
        ResetPasswordJob::dispatch($token, $user);
        return response()->json([
            "status" => true,
            "message" => "Check your email account a link to change your password has been sent"
        ], 200);
    }
}
