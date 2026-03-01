<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    public function index()
    {
        $kontaks = [
            'whatsapp' => 'Whatsapp',
            'instagram' => 'Instagram',
            'email' => 'Email',
            'nomor_telepon' => 'Nomor Telepon',
        ];

        $user = Auth::user();
        return view('dashboard.pages.settings', [
            'user' => $user,
            'kontak' => $user->kontak ?? []
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'nullable|string|max:50|unique:users,username,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'alamat' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'kontak_keys' => 'nullable|array',
            'kontak_values' => 'nullable|array',
        ]);

        // Build kontak associative array from dynamic fields
        $kontak = [];

        // If the form submitted a grouped kontak input (legacy), prefer it
        if ($request->filled('kontak') && is_array($request->input('kontak'))) {
            foreach ($request->input('kontak') as $k => $v) {
                $k = trim($k);
                $v = trim($v);
                if ($k !== '' && $v !== '') {
                    $kontak[$k] = $v;
                }
            }
        }

        // Merge/override with dynamic kontak_keys / kontak_values
        if ($request->has('kontak_keys') && is_array($request->kontak_keys)) {
            foreach ($request->kontak_keys as $i => $key) {
                $key = trim($key ?? '');
                $val = trim($request->kontak_values[$i] ?? '');
                if ($key !== '' && $val !== '') {
                    $kontak[$key] = $val;
                }
            }
        }

        // Assign profile fields explicitly to avoid mass-assign pitfalls
        $user->fullname = $request->input('fullname');
        $user->username = $request->input('username') ?? $user->username;
        $user->email = $request->input('email');
        $user->alamat = $request->input('alamat') ?? null;

        // Handle avatar removal
        if ($request->filled('remove_avatar') && $request->input('remove_avatar') == '1') {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = null;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->kontak = $kontak;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}
