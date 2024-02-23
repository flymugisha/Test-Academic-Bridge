<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\classes\Decript;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ResetPasswordController extends Controller
{
    public function viewResetPassword($token)
    {
        return view('user.resetPassword', compact('token'));
    }

    public function postResetPassword(Request $request, $token)
    {
        $request->validate(
            [
                'password' => ["required", Password::min(8)->numbers()->letters()->mixedCase()],
                'confirm-password' => ['same:password'],

            ],
        );
        $decri = new Decript;
        $token_decript = $decri->Decrypt($token);
        $user = User::where("email", $token_decript)->first();
        if ($user === null) {
            return back()->with("error", "Email not match with our old email");
        }
        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $user->email,
                'token' => $token,
            ])->first();
        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }
        $user->update(['password' => Hash::make($request->password)]);
        DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        return back()->with('success', "password is reseted successfully");
    }
}
