<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;

class MissingsController extends Controller
{
    public function index()
    {
        $missingPersons = OrangHilang::all();
        $missingAnimals = HewanHilang::all();
        $missingItems = BarangHilang::all();

        return view('dashboard.pages.missing', compact('missingPersons', 'missingAnimals', 'missingItems'));
    }
}
