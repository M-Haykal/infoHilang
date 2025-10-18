<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WilayahController extends Controller
{
    protected string $baseUrl = 'https://wilayah.id/api';

    /**
     * Ambil daftar provinsi.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProvinces()
    {
        $url = "{$this->baseUrl}/provinces.json";

        $data = Cache::remember('wilayah:provinces', 3600, function () use ($url) {
            $response = Http::timeout(10)->get($url);

            if ($response->successful() && $response->json('data')) {
                return $response->json('data');
            }

            return [];
        });

        return response()->json($data);
    }

    /**
     * Ambil daftar kabupaten/kota berdasarkan kode provinsi.
     *
     * @param string $provinceCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRegencies(string $provinceCode)
    {
        $url = "{$this->baseUrl}/regencies/{$provinceCode}.json";

        $data = Cache::remember("wilayah:regencies:{$provinceCode}", 3600, function () use ($url) {
            $response = Http::timeout(10)->get($url);

            if ($response->successful() && $response->json('data')) {
                return $response->json('data');
            }

            return [];
        });

        return response()->json($data);
    }

    /**
     * Ambil daftar kecamatan berdasarkan kode kabupaten/kota.
     *
     * @param string $regencyCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts(string $regencyCode)
    {
        $url = "{$this->baseUrl}/districts/{$regencyCode}.json";

        $data = Cache::remember("wilayah:districts:{$regencyCode}", 3600, function () use ($url) {
            $response = Http::timeout(10)->get($url);

            if ($response->successful() && $response->json('data')) {
                return $response->json('data');
            }

            return [];
        });

        return response()->json($data);
    }

    /**
     * Ambil daftar desa/kelurahan berdasarkan kode kecamatan.
     *
     * @param string $districtCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVillages(string $districtCode)
    {
        $url = "{$this->baseUrl}/villages/{$districtCode}.json";

        $data = Cache::remember("wilayah:villages:{$districtCode}", 3600, function () use ($url) {
            $response = Http::timeout(10)->get($url);

            if ($response->successful() && $response->json('data')) {
                return $response->json('data');
            }

            return [];
        });

        return response()->json($data);
    }
}
