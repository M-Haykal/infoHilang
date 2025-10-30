@extends('dashboard.layouts.index')

@section('title', 'Detail Laporan Orang Hilang | InfoHilang')

@section('content')
    {{-- ... konten detail laporan ... --}}

    @include('dashboard.components.commentars', [
        'model' => $orangHilang,
        'modelName' => 'App\Models\OrangHilang',
    ])

@endsection

@push('script')
    <script></script>
@endpush
