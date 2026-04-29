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

class ReportController extends Controller
{
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $reports = collect();

            // Ambil semua laporan dari semua model
            $orang = OrangHilang::select('id', 'nama as nama', 'created_at')
                ->get()
                ->map(function ($item) {
                    $item->kategori = 'orang';
                    $item->type = 'Orang Hilang';
                    return $item;
                });

            $hewan = HewanHilang::select('id', 'nama_hewan as nama', 'created_at')
                ->get()
                ->map(function ($item) {
                    $item->kategori = 'hewan';
                    $item->type = 'Hewan Hilang';
                    return $item;
                });

            $barang = BarangHilang::select('id', 'nama_barang as nama', 'created_at')
                ->get()
                ->map(function ($item) {
                    $item->kategori = 'barang';
                    $item->type = 'Barang Hilang';
                    return $item;
                });

            $reports = $reports->merge($orang)->merge($hewan)->merge($barang);

            // Filter kategori jika ada
            if ($request->has('kategori') && $request->kategori != 'all') {
                $reports = $reports->where('kategori', $request->kategori);
            }

            // Filter tanggal jika ada
            if ($request->has('start_date') && $request->has('end_date') && $request->start_date && $request->end_date) {
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end = Carbon::parse($request->end_date)->endOfDay();
                $reports = $reports->whereBetween('created_at', [$start, $end]);
            }

            return datatables()
                ->of($reports)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y H:i');
                })
                ->addColumn('action', function ($row) {
                    $url = match($row->kategori) {
                        'orang' => route('admin.report.show', ['type' => 'orang', 'id' => $row->id]),
                        'hewan' => route('admin.report.show', ['type' => 'hewan', 'id' => $row->id]),
                        'barang' => route('admin.report.show', ['type' => 'barang', 'id' => $row->id]),
                        default => '#'
                    };

                    return '<a href="'.$url.'" class="text-primary font-bold text-sm">Detail</a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('dashboard.pages.admin.manage-report');
    }

    public function show($type, $id)
    {
        switch ($type) {
            case 'orang':
                $report = OrangHilang::findOrFail($id);
                return view('dashboard.pages.detail-person-missing', compact('report', 'type'));
            case 'hewan':
                $report = HewanHilang::findOrFail($id);
                return view('dashboard.pages.detail-animal-missing', compact('report', 'type'));
            case 'barang':
                $report = BarangHilang::findOrFail($id);
                return view('dashboard.pages.detail-stuff-missing', compact('report', 'type'));
            default:
                abort(404);
        }
    }
}