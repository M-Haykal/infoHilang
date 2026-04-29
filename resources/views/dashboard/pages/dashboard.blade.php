@extends('dashboard.layouts.index')

@section('title', 'Dashboard | InfoHilang')

@section('content')

    <!-- Dashboard Section -->
    <div class="space-y-6" data-page="dashboard" id="dashboard">
        <!-- Header -->

        @if (auth()->user()->hasRole('user'))
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
                <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
                    <h1 class="text-3xl font-bold text-dark">Selamat Datang, {{ Auth::user()->fullname }}!</h1>
                    <p class="text-xs font-medium text-netral-400 mt-2">Kelola laporan barang, orang, atau hewan hilang.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-stuff-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Barang Hilang </h2>
                    <p class="text-2xl font-bold text-accent">{{ $missingItems }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-person-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Orang Hilang </h2>
                    <p class="text-2xl font-bold text-success">{{ $missingPersons }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-animal-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Hewan Hilang </h2>
                    <p class="text-2xl font-bold text-danger">{{ $missingAnimals }}</p>
                </div>
            </div>

            <section class="menu-laporan mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100"
                id="menu-report">
                <h2 class="text-2xl font-semibold text-dark mb-6">Buat Laporan Kehilangan Baru</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('form-barang-hilang') }}"
                        class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="200" id="add-stuff-missing">
                        <img src="{{ asset('img/item.png') }}" alt="Gambar Menu Barang"
                            class="w-full h-48 object-cover bg-primary-light">
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-dark">Tambah Laporan Barang Hilang</h3>
                            <p class="text-netral-500 text-sm mt-2">Laporkan barang yang hilang dengan detail dan lokasi.
                            </p>
                        </div>
                    </a>

                    <a href="{{ route('form-orang-hilang') }}"
                        class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="300" id="add-person-missing">
                        <img src="{{ asset('img/people.png') }}" alt="Gambar Menu Orang"
                            class="w-full h-48 object-cover bg-primary-light">
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-dark">Tambah Laporan Orang Hilang</h3>
                            <p class="text-netral-500 text-sm mt-2">Laporkan orang hilang dengan informasi lengkap.</p>
                        </div>
                    </a>

                    <a href="{{ route('form-hewan-hilang') }}"
                        class="block bg-white rounded-xl shadow-lg overflow-hidden transform hover:scale-105 transition-transform duration-300"
                        data-aos="zoom-in" data-aos-delay="400" id="add-animal-missing">
                        <img src="{{ asset('img/animal.png') }}" alt="Gambar Menu Hewan"
                            class="w-full h-48 object-cover bg-primary-light">
                        <div class="p-5">
                            <h3 class="text-lg font-semibold text-dark">Tambah Laporan Hewan Hilang</h3>
                            <p class="text-netral-500 text-sm mt-2">Laporkan hewan peliharaan yang hilang.</p>
                        </div>
                    </a>
                </div>
            </section>
        @endif

        {{-- UNTUK ROLE ADMIN: TAMPILKAN CHART DAN MENU ADMIN --}}
        @if (auth()->user()->hasRole('admin'))
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
                <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
                    <h1 class="text-3xl font-bold text-dark">Selamat Datang, {{ Auth::user()->fullname }}!</h1>
                    <p class="text-xs font-medium text-netral-400 mt-2">Monitor laporan kehilangan barang, orang, dan hewan.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-stuff-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Barang Hilang </h2>
                    <p class="text-2xl font-bold text-accent">{{ $missingItems }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-person-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Orang Hilang </h2>
                    <p class="text-2xl font-bold text-success">{{ $missingPersons }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md" id="missing-animal-card">
                    <h2 class="text-lg font-semibold text-dark">Pengaduan Hewan Hilang </h2>
                    <p class="text-2xl font-bold text-danger">{{ $missingAnimals }}</p>
                </div>
            </div>

            <section class="menu-admin mx-auto" data-aos="fade-up" id="admin-charts">
                {{-- Chart Section --}}
                <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
                    <div class="flex flex-col md:flex-row md:items-center justify-between mb-4 gap-4">
                        <h3 class="text-lg font-semibold text-dark">Traffic Laporan Hilang</h3>

                        {{-- Filter Tanggal --}}
                        <form id="filterChartForm" class="flex flex-wrap items-center gap-3">
                            <div class="flex items-center gap-2">
                                <label class="text-sm text-netral-600">Dari:</label>
                                <input type="date" name="start_date" id="start_date"
                                    value="{{ $chartData['startDate'] }}" class="border rounded px-3 py-1.5 text-sm">
                            </div>
                            <div class="flex items-center gap-2">
                                <label class="text-sm text-netral-600">Sampai:</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $chartData['endDate'] }}"
                                    class="border rounded px-3 py-1.5 text-sm">
                            </div>
                            <button type="submit"
                                class="bg-primary text-white px-4 py-1.5 rounded text-sm hover:bg-primary-dark transition">
                                Filter
                            </button>
                        </form>
                    </div>

                    {{-- Line Chart --}}
                    <div class="w-full">
                        <canvas id="trafficChart" height="400"></canvas>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection

@push('script')
    {{-- Script Chart JS --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if (auth()->user()->hasRole('admin'))
                // Inisialisasi Chart
                const ctx = document.getElementById('trafficChart').getContext('2d');

                let chartData = @json($chartData);

                let trafficChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                                label: 'Barang Hilang',
                                data: chartData.barang,
                                borderColor: '#3b82f6',
                                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#3b82f6'
                            },
                            {
                                label: 'Orang Hilang',
                                data: chartData.orang,
                                borderColor: '#10b981',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#10b981'
                            },
                            {
                                label: 'Hewan Hilang',
                                data: chartData.hewan,
                                borderColor: '#ef4444',
                                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                                tension: 0.4,
                                fill: true,
                                pointBackgroundColor: '#ef4444'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });

                // Filter Tanggal Form Handler
                document.getElementById('filterChartForm').addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    try {
                        const response = await fetch('{{ route('admin.dashboard.filter-chart') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]')?.content ||
                                    '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                start_date: startDate,
                                end_date: endDate
                            })
                        });

                        const data = await response.json();

                        // Update Chart Data
                        trafficChart.data.labels = data.labels;
                        trafficChart.data.datasets[0].data = data.orang;
                        trafficChart.data.datasets[1].data = data.hewan;
                        trafficChart.data.datasets[2].data = data.barang;
                        trafficChart.update();

                    } catch (error) {
                        console.error('Error fetching chart data:', error);
                        alert('Gagal memuat data chart, silahkan coba lagi');
                    }
                });
            @endif
        });
    </script>
@endpush
