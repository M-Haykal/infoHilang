<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrangHilang;
use App\Models\HewanHilang;
use App\Models\BarangHilang;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use DataTables;
use App\Services\MissingStuffService;
use App\Services\MissingPersonService;
use App\Services\MissingAnimalService;
use App\Models\LaporanDitemukan;

class ReportController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.admin.manage-report');
    }

    public function ajax(Request $request)
    {
        // Helper untuk build query dengan nama kolom yang DINAMIS
        $buildQuery = function($model, $nameColumn, $typeLabel) use ($request) {
            $query = $model->select('id', 'slug', $nameColumn . ' as nama', 'created_at');
            
            // Filter tanggal di level query (lebih efisien)
            if ($request->filled('start_date') && $request->filled('end_date')) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            }
            
            return $query->get()->map(function ($item) use ($typeLabel) {
                $item->type = $typeLabel;
                return $item;
            });
        };

        $reports = collect();

        // Filter per kategori
        if ($request->filled('kategori') && $request->kategori !== 'all') {
            match($request->kategori) {
                    'orang' => $reports = $buildQuery(new OrangHilang, 'nama_orang', 'Orang Hilang'),
                'hewan' => $reports = $buildQuery(new HewanHilang, 'nama_hewan', 'Hewan Hilang'),
                'barang' => $reports = $buildQuery(new BarangHilang, 'nama_barang', 'Barang Hilang'),
                default => $reports = collect()
            };
        } else {
            // Ambil semua kategori
            $reports = $reports
            ->merge($buildQuery(new OrangHilang, 'nama_orang', 'Orang Hilang'))
            ->merge($buildQuery(new HewanHilang, 'nama_hewan', 'Hewan Hilang'))
            ->merge($buildQuery(new BarangHilang, 'nama_barang', 'Barang Hilang'));
        }

        return datatables()
            ->of($reports)
            ->addIndexColumn()
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d M Y H:i') ?? '-')
            ->addColumn('action', function ($row) {
            $url = match($row->type) {
                'Orang Hilang' => route('admin.report.detail.orang', $row->slug),
                'Hewan Hilang' => route('admin.report.detail.hewan', $row->slug),
                'Barang Hilang' => route('admin.report.detail.barang', $row->slug),
                default => '#'
            };
                return '<a href="'.$url.'" class="text-primary font-bold text-sm hover:underline">Detail</a>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function showBarang($slug)
    {
        $barangHilang = BarangHilang::where('slug', $slug)->firstOrFail();
        $barangHilang->load(['comentars.user', 'comentars.replies.user']);
        
        $laporanDitemukan = LaporanDitemukan::where('foundable_id', $barangHilang->id)
            ->where('foundable_type', BarangHilang::class)
            ->with('user')
            ->latest()
            ->get();

        return view('dashboard.pages.detail-stuff-missing', compact('barangHilang', 'laporanDitemukan'));
    }

    public function showOrang($slug)
    {
        $orangHilang = OrangHilang::where('slug', $slug)->firstOrFail();
        $orangHilang->load(['comentars.user', 'comentars.replies.user']);
        
        $laporanDitemukan = LaporanDitemukan::where('foundable_id', $orangHilang->id)
            ->where('foundable_type', OrangHilang::class)
            ->with('user')
            ->latest()
            ->get();

        return view('dashboard.pages.detail-person-missing', compact('orangHilang', 'laporanDitemukan'));
    }

    public function showHewan($slug)
    {
        $hewanHilang = HewanHilang::where('slug', $slug)->firstOrFail();
        $hewanHilang->load(['comentars.user', 'comentars.replies.user']);
        
        $laporanDitemukan = LaporanDitemukan::where('foundable_id', $hewanHilang->id)
            ->where('foundable_type', HewanHilang::class)
            ->with('user')
            ->latest()
            ->get();

        return view('dashboard.pages.detail-animal-missing', compact('hewanHilang', 'laporanDitemukan'));
    }

}