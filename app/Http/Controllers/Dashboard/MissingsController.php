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
    public function index(Request $request)
    {
        $userId = Auth::id();
        $missingItems = BarangHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_item');
        $missingPersons = OrangHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_person');
        $missingAnimals = HewanHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_animal');

        if ($request->ajax()) {
            return response()->json([
                'html' => view('dashboard.components._missing_content', compact('missingItems', 'missingPersons', 'missingAnimals'))->render()
            ]);
        }

        return view('dashboard.pages.missing', compact('missingItems', 'missingPersons', 'missingAnimals'));
    }
}
