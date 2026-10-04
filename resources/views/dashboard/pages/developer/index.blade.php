@extends('dashboard.layouts.index')

@section('title', 'Developer Dashboard')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-4 mb-2">
        <div class="bg-primary/10 p-3 rounded-2xl">
            <i class="fa-solid fa-code text-2xl text-primary"></i>
        </div>
        <div>
            <h1 class="text-3xl font-bold text-dark tracking-tight">Dashboard Developer</h1>
            <p class="text-netral-500 mt-1">Selamat datang kembali, {{ auth()->user()->fullname }}!</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white p-6 rounded-2xl border border-netral-100 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow">
        <div class="bg-blue-50 p-4 rounded-xl text-blue-600">
            <i class="fa-solid fa-server text-xl"></i>
        </div>
        <div>
            <p class="text-sm font-semibold text-netral-500 mb-1">Status Server</p>
            <h3 class="text-2xl font-bold text-dark">Online</h3>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <a href="{{ route('log-viewer.index') }}" class="block bg-white p-6 rounded-2xl border border-netral-100 shadow-sm hover:shadow-md hover:border-primary/30 transition-all group">
        <div class="flex items-start gap-4">
            <div class="bg-orange-50 p-4 rounded-xl text-orange-600 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-file-code text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-semibold text-netral-500 mb-1">Log Sistem</p>
                <h3 class="text-2xl font-bold text-dark">Lihat Detail <i class="fa-solid fa-arrow-right text-sm ml-1 text-netral-400 group-hover:text-primary transition-colors"></i></h3>
            </div>
        </div>
    </a>
</div>

<div class="bg-white rounded-2xl border border-netral-100 shadow-sm overflow-hidden">
    <div class="p-6 border-b border-netral-100">
        <h2 class="text-lg font-bold text-dark">Informasi Sistem</h2>
    </div>
    <div class="p-6">
        <ul class="space-y-4 text-sm">
            <li class="flex justify-between items-center py-2 border-b border-netral-50">
                <span class="text-netral-500 font-medium">Versi Laravel</span>
                <span class="font-bold text-dark">{{ app()->version() }}</span>
            </li>
            <li class="flex justify-between items-center py-2 border-b border-netral-50">
                <span class="text-netral-500 font-medium">Versi PHP</span>
                <span class="font-bold text-dark">{{ phpversion() }}</span>
            </li>
            <li class="flex justify-between items-center py-2 border-b border-netral-50">
                <span class="text-netral-500 font-medium">Environment</span>
                <span class="font-bold text-dark uppercase">{{ env('APP_ENV') }}</span>
            </li>
        </ul>
    </div>
</div>
@endsection
