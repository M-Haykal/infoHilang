<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $missingPersons = OrangHilang::where('user_id', $userId)->count();
        $missingAnimals = HewanHilang::where('user_id', $userId)->count();
        $missingItems = BarangHilang::where('user_id', $userId)->count();

        return view('dashboard.pages.dashboard', compact('missingPersons', 'missingAnimals', 'missingItems'));
    }
}
