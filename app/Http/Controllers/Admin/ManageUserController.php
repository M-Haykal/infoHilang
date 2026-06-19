<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use DataTables;

class ManageUserController extends Controller
{
    public function index()
    {
        return view('dashboard.pages.admin.manage-user');
    }

    public function ajax(Request $request)
    {
        $query = User::where('role', 'user')
            ->select('id', 'username', 'email', 'created_at', 'updated_at');

        // Filter tanggal jika ada
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        return datatables()
            ->of($query)
            ->addIndexColumn()
            ->editColumn('created_at', fn($row) => $row->created_at?->format('d M Y H:i') ?? '-')
            ->editColumn('updated_at', fn($row) => $row->updated_at?->format('d M Y H:i') ?? '-')
            ->addColumn('action', function ($row) {
                return '<div class="flex gap-2">
                    <button class="text-primary font-bold text-sm hover:underline">Edit</button>
                    <button class="text-red-600 font-bold text-sm hover:underline">Hapus</button>
                </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}