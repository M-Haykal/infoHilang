<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserContactController extends Controller
{
    /**
     * Return a JSON list of users and their kontak values.
     * Accepts optional ?search= query parameter.
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');

        $users = User::query()
            ->when($search, function ($q, $search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->limit(10)
            ->get();

        $result = $users->map(function ($user) {
            $kontak = [];
            if (is_array($user->kontak)) {
                $kontak = $user->kontak;
            } else {
                $kontak = json_decode($user->kontak, true) ?: [];
            }

            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'kontak' => $kontak,
            ];
        });

        return response()->json($result);
    }
}
