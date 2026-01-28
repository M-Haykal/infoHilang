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
        // $missingPersons = OrangHilang::where('user_id', $userId)->select('nama_orang', 'lokasi_terakhir_dilihat', 'tanggal_terakhir_dilihat', 'status', 'slug', 'foto')->paginate(10);
        // $missingAnimals = HewanHilang::where('user_id', $userId)->select('nama_hewan', 'lokasi_terakhir_dilihat', 'tanggal_terakhir_dilihat', 'status', 'slug', 'foto')->paginate(10);
        // $missingItems = BarangHilang::where('user_id', $userId)->select('nama_barang', 'lokasi_terakhir_dilihat', 'tanggal_terakhir_dilihat', 'status', 'slug', 'foto')->paginate(10);

        $missingPersons = OrangHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_person')->withQueryString();
        $missingAnimals = HewanHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_animal')->withQueryString();
        $missingItems = BarangHilang::where('user_id', $userId)->paginate(10, ['*'], 'page_item')->withQueryString();

        return view('dashboard.pages.missing', compact('missingPersons', 'missingAnimals', 'missingItems'));
    }
}
