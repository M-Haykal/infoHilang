<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $missingPersons = OrangHilang::count();
        $missingAnimals = HewanHilang::count();
        $missingItems = BarangHilang::count();

        // Default date range 30 hari terakhir
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));

        // Generate data per hari untuk chart
        $dates = [];
        $orangData = [];
        $hewanData = [];
        $barangData = [];

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $date->format('d M');

            $orangData[] = OrangHilang::whereDate('created_at', $formattedDate)->count();
            $hewanData[] = HewanHilang::whereDate('created_at', $formattedDate)->count();
            $barangData[] = BarangHilang::whereDate('created_at', $formattedDate)->count();
        }

        $chartData = [
            'labels' => $dates,
            'orang' => $orangData,
            'hewan' => $hewanData,
            'barang' => $barangData,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];

        return view('dashboard.pages.dashboard', compact('missingPersons', 'missingAnimals', 'missingItems', 'chartData'));
    }

    // Method untuk AJAX filter tanggal
    public function filterChart(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Generate data per hari untuk chart
        $dates = [];
        $orangData = [];
        $hewanData = [];
        $barangData = [];

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
            $formattedDate = $date->format('Y-m-d');
            $dates[] = $date->format('d M');

            $orangData[] = OrangHilang::whereDate('created_at', $formattedDate)->count();
            $hewanData[] = HewanHilang::whereDate('created_at', $formattedDate)->count();
            $barangData[] = BarangHilang::whereDate('created_at', $formattedDate)->count();
        }

        return response()->json([
            'labels' => $dates,
            'orang' => $orangData,
            'hewan' => $hewanData,
            'barang' => $barangData
        ]);
    }
}
