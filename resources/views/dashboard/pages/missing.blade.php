@extends('dashboard.layouts.index')

@section('title', 'History Laporan Hilang | InfoHilang')

@section('content')
<div class="space-y-6">
    <header class="text-center">
        <h1 class="text-2xl font-bold text-dark mb-2">Daftar Laporan Hilang</h1>
        <p class="text-netral-500">Pantau dan kelola laporan kehilangan dengan mudah.</p>
    </header>

    <section class="menu-history-hilang max-w-6xl mx-auto" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Tab Headers -->
            <div class="flex flex-col sm:flex-row justify-between border-b border-netral-100">

                <h2 class="hidden md:block self-center text-xl font-bold text-primary ml-6 my-auto">Histori Laporan</h2>

                <div class="flex space-x-1 sm:space-x-2 p-2 sm:ml-auto sm:self-center justify-end">
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300 active" data-tab="tab-barang">
                        <i class="hidden md:block fa-solid fa-box mr-2"></i>
                        Barang Hilang
                    </button>
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300" data-tab="tab-orang">
                        <i class="hidden md:block fa-solid fa-user mr-2"></i>
                        Orang Hilang
                    </button>
                    <button class="tab-button flex items-center px-4 sm:px-6 py-3 font-medium text-sm text-netral-500 rounded-lg transition-all duration-300" data-tab="tab-hewan">
                        <i class="hidden md:block fa-solid fa-paw mr-2"></i>
                        Hewan Hilang
                    </button>
                </div>
            </div>

            <!-- Tab Content -->
            <div id="ajax-pagination-container">
                @include('dashboard.components._missing_content')
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
<script>
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active', 'bg-primary/10', 'text-primary');
                btn.classList.add('text-accent/500');
            });

            // Add active class to clicked button
            button.classList.add('active', 'bg-primary/10', 'text-primary');
            button.classList.remove('text-accent/500');

            // Hide all tab panes
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.add('hidden');
            });

            // Show the targeted tab pane
            const tabId = button.dataset.tab;
            document.getElementById(tabId).classList.remove('hidden');
        });
    });

    document.addEventListener('click', function(e) {
        // Cari tombol pagination
        const link = e.target.closest('.pagination a, .ajax-pagination a');

        if (link) {
            e.preventDefault();
            const url = link.getAttribute('href');
            loadDashboardData(url);
        }
    });

    function loadDashboardData(url) {
        const container = document.getElementById('ajax-pagination-container');
        container.style.opacity = '0.5';

        fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                container.innerHTML = data.html;
                container.style.opacity = '1';
                maintainActiveTab();
            })
            .catch(error => {
                console.error('Error:', error);
                container.style.opacity = '1';
            });
    }

    let currentActiveTabId = 'tab-barang';

    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', function() {
            currentActiveTabId = this.getAttribute('data-tab');
        });
    });

    function maintainActiveTab() {
        // Sembunyikan semua pane
        document.querySelectorAll('.tab-pane').forEach(p => p.classList.add('hidden'));

        // Tampilkan kembali tab yang sedang aktif sebelum AJAX tadi
        const activePane = document.getElementById(currentActiveTabId);
        if (activePane) {
            activePane.classList.remove('hidden');
        }
    }

</script>
@endpush
