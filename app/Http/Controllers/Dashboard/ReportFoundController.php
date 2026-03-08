<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportFoundController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.report-found');
    }
}
