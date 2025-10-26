<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;

class DashboardController extends Controller
{
    public function index()
    {
        $missingPersons = OrangHilang::count();
        $missingAnimals = HewanHilang::count();
        $missingItems = BarangHilang::count();

        return view('dashboard.pages.dashboard', compact('missingPersons', 'missingAnimals', 'missingItems'));
    }
}
