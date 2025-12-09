<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MissingAnimalController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $animalsJson = public_path('json/animals.json');

        if (!file_exists($animalsJson)) {
            return view('dashboard.pages.form-animal-missing', ['animals' => [], 'error' => 'File not found.']);
        }

        $json = file_get_contents($animalsJson);
        $animals = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return view('dashboard.pages.form-animal-missing', ['animals' => [], 'error' => 'Error decoding JSON data.']);
        }

        return view('dashboard.pages.form-animal-missing', compact('userId', 'animals'));
    }
}
