@extends('dashboard.layouts.index')

@section('title', 'Dashboard | InfoHilang')

@section('content')

    <!-- Dashboard Section -->
    <div class="space-y-6">
        <header>
            <h1 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->username }}!</h1>
            <p class="text-gray-600">Here's what's happening with your account today.</p>
        </header>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Hilang Barang</h2>
                <p class="text-2xl font-bold text-highlight">{{ $missingItems }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Hilang Orang</h2>
                <p class="text-2xl font-bold text-success">{{ $missingPersons }}</p>
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold text-gray-700">Pengaduan Hilang Hewan</h2>
                <p class="text-2xl font-bold text-danger">{{ $missingAnimals }}</p>
            </div>
        </div>
    </div>
@endsection
