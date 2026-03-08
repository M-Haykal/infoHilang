<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LaporanDitemukan;

class ReportFoundController extends Controller
{
    public function index()
    {
        $reports = LaporanDitemukan::with('user')->get();
        return view('dashboard.pages.report-found', compact('reports'));
    }

    public function toggleConfirm($id)
    {
        $report = LaporanDitemukan::findOrFail($id);

        $report->is_confirmed = !$report->is_confirmed;
        $report->save();

        return redirect()->back()->with('success', 'Status laporan berhasil diperbarui');
    }
}
