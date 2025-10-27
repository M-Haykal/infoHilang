<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MissingStuffController extends Controller
{
    public function index()
    {
        $userId = Auth::user()->id;
        $characteristics = ['Tinggi Badan', 'Berat Badan', 'Warna Rambut', 'Warna Kulit', 'Bentuk Wajah', 'Tanda Lahir'];
        $contacts = ['Nomor Telepon', 'Nomor WhatsApp', 'Alamat Email', 'Instagram', 'Facebook', 'Twitter'];

        return view('dashboard.pages.form-stuff-missing', compact('userId', 'characteristics', 'contacts'));
    }
}
