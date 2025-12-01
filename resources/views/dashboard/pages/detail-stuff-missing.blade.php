@include('dashboard.layouts.index')

@section('title', 'Detail Laporan Barang Hilang | InfoHilang')

@section('content')
    <section class="m-4">
        <h1 class="text-2xl font-bold mb-4">{{ $barangHilang->nama_barang }}</h1>
        
    </section>
@endsection
