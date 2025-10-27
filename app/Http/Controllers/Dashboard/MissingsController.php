<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;
use Auth;

class MissingsController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $missingPersons = OrangHilang::where('user_id', $userId)->get();
        $missingAnimals = HewanHilang::where('user_id', $userId)->get();
        $missingItems = BarangHilang::where('user_id', $userId)->get();

        return view('dashboard.pages.missing', compact('missingPersons', 'missingAnimals', 'missingItems'));
    }
}
