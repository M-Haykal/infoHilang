@push('style')
    <link rel="stylesheet" href="{{ asset('css/loading.css') }}">
@endpush
<!-- Loading Screen -->
<div id="global-loader"
    class="fixed inset-0 bg-secondary z-50 flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <div class="inline-block h-12 w-12 animate-spin rounded-full border-4 border-orange-500 border-t-transparent"></div>
        <p class="mt-4 text-orange-500">Memuat...</p>
    </div>
</div>

@push('script')
    <script src="{{ asset('js/loading.js') }}"></script>
@endpush
