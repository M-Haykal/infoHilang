<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;
use Illuminate\Support\Facades\Log;

class SiteMapController extends Controller
{
    public function generate()
    {
        try {
            $url = config('app.url');
            $path = public_path('sitemap.xml');

            // Debug: lihat URL dan path
            Log::info('Generating sitemap from: ' . $url);
            Log::info('Saving to: ' . $path);

            SitemapGenerator::create($url)
                ->writeToFile($path);

            // Cek apakah file benar-benar tersimpan
            if (file_exists($path)) {
                return response()->json([
                    'message' => 'Sitemap generated successfully!',
                    'url' => $url,
                    'path' => $path,
                    'size' => filesize($path) . ' bytes'
                ]);
            } else {
                return response()->json([
                    'error' => 'File not found after generation'
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Sitemap generation failed: ' . $e->getMessage());

            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }
}
