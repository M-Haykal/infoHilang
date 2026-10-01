<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SSEController extends Controller
{
    /**
     * SSE endpoint untuk real-time update jumlah laporan di dashboard.
     * Untuk role user: hanya menampilkan laporan milik user tersebut.
     * Untuk role admin: menampilkan total seluruh laporan.
     */
    public function stream(Request $request)
    {
        // Set SSE headers
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('Connection: keep-alive');
        header('X-Accel-Buffering: no');

        // Pastikan user terautentikasi
        if (!Auth::check()) {
            echo "data: {\"error\": \"Unauthenticated\"}\n\n";
            ob_flush();
            flush();
            return;
        }

        $user = Auth::user();
        $isAdmin = $user->hasRole('admin');

        // Kirim data setiap 5 detik
        while (true) {
            if ($isAdmin) {
                $missingItems = BarangHilang::count();
                $missingPersons = OrangHilang::count();
                $missingAnimals = HewanHilang::count();
            } else {
                $userId = $user->id;
                $missingItems = BarangHilang::where('user_id', $userId)->count();
                $missingPersons = OrangHilang::where('user_id', $userId)->count();
                $missingAnimals = HewanHilang::where('user_id', $userId)->count();
            }

            $data = json_encode([
                'missing_items' => $missingItems,
                'missing_persons' => $missingPersons,
                'missing_animals' => $missingAnimals,
                'timestamp' => now()->toIso8601String(),
            ]);

            echo "data: {$data}\n\n";
            ob_flush();
            flush();

            // Cek jika koneksi terputus
            if (connection_aborted()) {
                break;
            }

            sleep(5);
        }
    }
}