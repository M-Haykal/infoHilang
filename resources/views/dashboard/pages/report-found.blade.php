@extends('dashboard.layouts.index')

@section('title', 'Daftar Laporan Ditemukan | InfoHilang')

@section('content')
    <div class="space-y-6" x-data="{ open: false, report: {} }">

        <!-- Header -->
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
            <div class="text-center lg:text-left">
                <h1 class="text-3xl font-bold text-dark">Daftar Laporan Ditemukan</h1>
                <p class="text-xs font-medium text-netral-400 mt-2">
                    Pantau dan kelola laporan ditemukan dengan mudah.
                </p>
            </div>
        </div>

        <!-- List Card -->
        <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-5">

            @foreach ($reports as $report)
                <div @click="open=true; report={
                id:'{{ $report->id }}',
                nama:'{{ $report->nama_penemu }}',
                kontak:'{{ $report->kontak_penemu }}',
                lokasi:'{{ $report->lokasi_ditemukan }}',
                tanggal:'{{ $report->tanggal_ditemukan }}',
                keterangan:`{{ $report->keterangan }}`,
                pelapor:'{{ $report->user_id ? $report->user->name : 'Anonim' }}',
                confirmed:'{{ $report->is_confirmed }}'
            }"
                    class="bg-white border rounded-xl p-5 shadow-sm cursor-pointer hover:shadow-md transition">

                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">
                            {{ $report->nama_penemu ?? 'Anonim' }}
                        </h3>

                        @if ($report->is_confirmed)
                            <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-600">
                                Confirmed
                            </span>
                        @else
                            <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-600">
                                Pending
                            </span>
                        @endif
                    </div>

                    <div class="mt-3 text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Kontak:</span> {{ $report->kontak_penemu ?? 'Anonim' }}</p>
                        <p><span class="font-medium">Lokasi:</span> {{ $report->lokasi_ditemukan ?? '-' }}</p>
                        <p class="text-xs text-gray-400">
                            {{ $report->tanggal_ditemukan ? \Carbon\Carbon::parse($report->tanggal_ditemukan)->format('d M Y') : '-' }}
                        </p>
                    </div>

                </div>
            @endforeach

        </div>


        <!-- MODAL DETAIL -->
        {{-- <div x-show="open" x-transition class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

            <div @click.away="open=false" class="bg-white rounded-xl shadow-lg w-full max-w-lg p-6 space-y-4">

                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-gray-800">
                        Detail Laporan
                    </h2>

                    <button @click="open=false" class="text-gray-400 hover:text-gray-600">
                        ✕
                    </button>
                </div>

                <div class="text-sm text-gray-600 space-y-2">

                    <p><span class="font-semibold">Nama Penemu:</span> <span x-text="report.nama"></span></p>

                    <p><span class="font-semibold">Kontak:</span> <span x-text="report.kontak"></span></p>

                    <p><span class="font-semibold">Pelapor:</span> <span x-text="report.pelapor"></span></p>

                    <p><span class="font-semibold">Lokasi:</span> <span x-text="report.lokasi"></span></p>

                    <p><span class="font-semibold">Tanggal:</span> <span x-text="report.tanggal"></span></p>

                    <p class="pt-2 border-t">
                        <span class="font-semibold">Keterangan:</span><br>
                        <span x-text="report.keterangan"></span>
                    </p>

                </div>

                <!-- Confirm Button -->
                <form :action="''" method="POST"
                    class="pt-3 border-t flex justify-end">
                    @csrf
                    @method('PATCH')

                    <button class="px-4 py-2 text-sm rounded bg-blue-600 text-white hover:bg-blue-700">
                        Toggle Confirm
                    </button>
                </form>

            </div>
        </div> --}}

    </div>
@endsection
