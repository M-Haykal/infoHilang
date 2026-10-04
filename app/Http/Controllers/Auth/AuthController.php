<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\SendWelcomeToInfoHilang;

class AuthController extends Controller
{
    private function generateUniqueUsername($firstname, $lastname)
    {
        $baseUsername = Str::slug($firstname . ' ' . $lastname); // muhammad-haykal
        $username = $baseUsername;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . '-' . $counter;
            $counter++;
        }

        return $username;
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->login;
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($field, $login)->first();

        if ($user && $user->google_id && !$user->password) {
            return back()->withErrors([
                'login' => 'Akun ini terdaftar menggunakan Google.'
            ])->onlyInput('login');
        }

        if (Auth::attempt([$field => $login, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            // Cek role user setelah login
            if (Auth::user()->hasRole('developer')) {
                return redirect()->intended('/developer/dashboard')->with('success', 'Berhasil login sebagai Developer!');
            } elseif (Auth::user()->hasRole('admin')) {
                return redirect()->intended('/admin/dashboard')->with('success', 'Berhasil login sebagai Admin!');
            }
            
            return redirect()->intended('/user/dashboard')->with('success', 'Berhasil login!');
        }

        return back()->withErrors([
            'login' => 'Email / Username atau password salah.'
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'username.unique' => 'Username sudah digunakan. Silakan pilih username lain.',
        ]);

        $user = User::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        Mail::to($user->email)->send(new SendWelcomeToInfoHilang($user));

        return redirect('/')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }
}
