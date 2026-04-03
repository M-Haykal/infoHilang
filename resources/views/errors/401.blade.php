@extends('errors.layout')

@section('title', 'Akses Tidak Diizinkan')

@section('icon_bg', 'bg-danger/10')
@section('icon_color', 'text-danger')

@section('icon')
    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
    </svg>
@endsection

@section('code', '401')

@section('message', 'Anda perlu login terlebih dahulu untuk mengakses halaman ini.')

@section('actions')
    <a href="{{ route('login') }}"
        class="px-6 py-2.5 rounded-lg font-medium transition-all duration-200 text-sm bg-danger hover:bg-danger-dark text-white shadow-md hover:shadow-lg hover:-translate-y-0.5">
        Login
    </a>
    <button onclick="window.history.back()"
        class="px-6 py-2.5 rounded-lg font-medium transition-all duration-200 text-sm border border-danger text-danger bg-transparent hover:bg-danger/5 hover:-translate-y-0.5">
        Kembali
    </button>
@endsection
