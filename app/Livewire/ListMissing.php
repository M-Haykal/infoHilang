<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\BarangHilang;
use App\Models\HewanHilang;
use App\Models\OrangHilang;

class ListMissing extends Component
{
    use WithPagination;

    public $userLat;
    public $userLng;
    public $radius = 5;
    public $mapReports = [];

    public $viewMode = 'grid';
    public string $search = '';
    public string $status = 'Hilang';
    public string $kategori = '';
    public string $lokasi = '';
    public string $date = '';

    protected $paginationTheme = 'tailwind';

    protected $listeners = ['setUserLocation'];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => 'Hilang'],
        'kategori' => ['except' => ''],
        'lokasi' => ['except' => ''],
        'date' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    public function setView($mode)
    {
        $this->viewMode = $mode;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updating($property)
    {
        if (in_array($property, ['status', 'kategori', 'lokasi', 'date'])) {
            $this->resetPage();
        }
    }

    public function resetFilters()
    {
        $this->reset(['search', 'status', 'kategori', 'lokasi', 'date']);
    }

    public function render()
    {
        $barang = $this->getBarangQuery()->get();
        $hewan = $this->getHewanQuery()->get();
        $orang = $this->getOrangQuery()->get();

        $all = collect()->merge($barang)->merge($hewan)->merge($orang);

        // Tambahkan report_type & normalisasi kolom yang dipakai di Blade
        $all = $all->map(function ($item) {
            // Tentukan tipe laporan
            if ($item instanceof BarangHilang) {
                $item->report_type = 'Barang';
                $item->report_name = $item->nama_barang;
                $item->deskripsi = $item->deskripsi_barang;
            } elseif ($item instanceof HewanHilang) {
                $item->report_type = 'Hewan';
                $item->report_name = $item->nama_hewan;
                $item->deskripsi = $item->deskripsi_hewan;
            } elseif ($item instanceof OrangHilang) {
                $item->report_type = 'Orang';
                $item->report_name = $item->nama_orang;
                $item->deskripsi = $item->deskripsi_orang;
            }

            // Pastikan kolom lokasi & tanggal konsisten
            $item->lokasi = $item->lokasi_terakhir_dilihat ?? $item->lokasi ?? '';
            return $item;
        });

        // Sorting berdasarkan yang terbaru
        $all = $all->sortByDesc('created_at');

        // Manual pagination
        $perPage = 9;
        $currentPage = $this->getPage();
        $paginatedItems = $all->forPage($currentPage, $perPage)->values();
        $reports = new LengthAwarePaginator(
        $paginatedItems,
        $all->count(),
        $perPage,
        $currentPage,
        [
            'path' => request()->url(),
            'as' => 'page',
        ]
    );

        return view('livewire.list-missing', [
            'reports' => $reports
        ])
        ->layout('layouts.index')
        ->title('Daftar Hilang | InfoHilang');
    }

    private function getBarangQuery()
    {
        $query = BarangHilang::query();

        if ($this->search) {
            $keyword = '%' . $this->search . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_barang', 'like', $keyword)
                    ->orWhere('deskripsi_barang', 'like', $keyword)
                    ->orWhere('jenis_barang', 'like', $keyword)
                    ->orWhere('merk_barang', 'like', $keyword);
            });
        }

        $this->applyCommonFilters($query);
        return $query;
    }

    private function getHewanQuery()
    {
        $query = HewanHilang::query();

        if ($this->search) {
            $keyword = '%' . $this->search . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_hewan', 'like', $keyword)
                    ->orWhere('deskripsi_hewan', 'like', $keyword)
                    ->orWhere('ras', 'like', $keyword)
                    ->orWhere('warna', 'like', $keyword);
            });
        }

        $this->applyCommonFilters($query);
        return $query;
    }

    private function getOrangQuery()
    {
        $query = OrangHilang::query();

        if ($this->search) {
            $keyword = '%' . $this->search . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('nama_orang', 'like', $keyword)
                    ->orWhere('deskripsi_orang', 'like', $keyword)
                    ->orWhere('ciri_ciri', 'like', $keyword);
            });
        }

        $this->applyCommonFilters($query);
        return $query;
    }

    private function applyCommonFilters($query)
    {
        // Status
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Lokasi
        if ($this->lokasi) {
            $query->where('lokasi_terakhir_dilihat', 'like', '%' . $this->lokasi . '%');
        }

        // Tanggal
        if ($this->date) {
            $query->whereDate('tanggal_terakhir_dilihat', $this->date);
        }

        // Kategori filter
        if ($this->kategori) {
            $modelClass = $query->getModel()::class;
            $allowed = [
                'Barang' => BarangHilang::class,
                'Hewan' => HewanHilang::class,
                'Orang' => OrangHilang::class,
            ];

            if ($modelClass !== $allowed[$this->kategori]) {
                $query->whereRaw('1 = 0'); // kosongkan hasil
            }
        }
    }

    public function setUserLocation($lat, $lng)
    {
        $this->userLat = $lat;
        $this->userLng = $lng;

        $this->loadMapReports();
    }

    private function loadMapReports()
    {
        if (!$this->userLat || !$this->userLng)
            return;

        $all = collect()
            ->merge($this->getBarangQuery()->get())
            ->merge($this->getHewanQuery()->get())
            ->merge($this->getOrangQuery()->get());

        $this->mapReports = $all
            ->filter(fn($item) => $item->latitude && $item->longitude)
            ->map(function ($item) {
                $distance = $this->distanceKm(
                    $this->userLat,
                    $this->userLng,
                    $item->latitude,
                    $item->longitude
                );

                if ($distance > $this->radius)
                    return null;

                return [
                    'id' => $item->id,
                    'lat' => $item->latitude,
                    'lng' => $item->longitude,
                    'type' => class_basename($item),
                    'distance' => round($distance, 2),
                ];
            })
            ->filter()
            ->values()
            ->toArray();

        $this->dispatch('refreshMap', $this->mapReports);
    }

    private function distanceKm($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) *
            cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        return $earthRadius * 2 * asin(sqrt($a));
    }

}
