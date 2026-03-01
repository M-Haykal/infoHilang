@extends('dashboard.layouts.index')

@section('title', 'Daftar Laporan Hilang | InfoHilang')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
        <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
            <h1 class="text-3xl font-bold text-dark">Daftar Laporan Hilang</h1>
            <p class="text-xs font-medium text-netral-400 mt-2">Pantau dan kelola laporan kehilangan dengan mudah.</p>
        </div>
    </div>

    <section class="menu-history-hilang max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Tab Headers -->
            <div class="flex flex-col sm:flex-row justify-between border-b border-netral-100">

                <h2 class="hidden md:block self-center text-xl font-bold text-primary ml-6 my-auto">Laporan</h2>

                <div class="flex space-x-1 sm:space-x-2 p-2 sm:ml-auto sm:self-center justify-end">
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300 active" data-tab="tab-orang">
                        <i class="hidden md:block fa-solid fa-user mr-2"></i>
                        Orang Hilang
                    </button>
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300" data-tab="tab-barang">
                        <i class="hidden md:block fa-solid fa-box mr-2"></i>
                        Barang Hilang
                    </button>
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300" data-tab="tab-hewan">
                        <i class="hidden md:block fa-solid fa-paw mr-2"></i>
                        Hewan Hilang
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div id="ajax-pagination-container">
                @include('dashboard.components.missing_content')
            </div>
        </div>
    </section>
</div>
@endsection

@push('style')
<style>
    .tab-button.active {
        color: oklch(54.6% 0.245 262.881) !important;
        background-color: oklch(97% 0.014 254.604);
    }

    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

</style>
@endpush

@push('script')
<script src="{{ asset('js/dashboard/missing-reports.js') }}"></script>
@endpush
