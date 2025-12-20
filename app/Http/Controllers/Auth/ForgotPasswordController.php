<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Mail\SendEmailResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendEmailResetPasswordJob;

class ForgotPasswordController extends Controller
{
    /**
     * Summary of showForgotPasswordForm
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showForgotPasswordForm()
    {
        return view('auth.email-forgot');
    }

    /**
     * Summary of sendResetLinkEmail
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.']);
        }

        $token = Password::createToken($user);
        dispatch(new SendEmailResetPasswordJob($user, $token));

        return back()->with('success', 'Link reset password telah dikirim ke email Anda.');

    }
}
