<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendWelcomeToInfoHilang;
use Illuminate\Support\Facades\Mail;

class GoogleAuthController extends Controller
{
    /**
     * Summary of redirectToGoogle
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Summary of handleGoogleCallback
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            if ($existingUser) {
                $isFirstGoogleLogin = empty($existingUser->google_id);

                $existingUser->update([
                    'google_id' => $googleUser->getId(),
                    'email_verified_at' => now(),
                ]);

                if ($isFirstGoogleLogin) {
                    Mail::to($existingUser->email)->send(new SendWelcomeToInfoHilang($existingUser));
                }

                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make($googleUser->getId()), 
                ]);

                Auth::login($newUser);
            }

            return redirect()->route('dashboard');
        } catch (\Throwable $th) {
            // optionally log the exception: \Log::error($th);
            return redirect()->route('login')->withErrors('Unable to login using Google. Please try again.');
        }
    }
}
