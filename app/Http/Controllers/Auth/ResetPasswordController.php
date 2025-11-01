<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Summary of showResetForm
     * @param \Illuminate\Http\Request $request
     * @param mixed $token
     * @return \Illuminate\Contracts\View\View
     */
    public function showResetForm(Request $request, $token)
    {
        return view('auth.form-forgot')->with(
            ['token' => $token, 'email' => request('email')]
        );
    }

    /**
     * Summary of resetPassword
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password Anda telah berhasil diatur ulang.')
            : back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
    }
}
