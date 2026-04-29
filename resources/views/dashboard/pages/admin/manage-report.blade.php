@extends('dashboard.layouts.index')

@section('title', 'Kelola Laporan | InfoHilang Admin')

@section('content')

<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-dark">Kelola Semua Laporan</h1>
            <p class="text-sm text-netral-500 mt-1">Lihat dan kelola semua laporan orang, hewan dan barang hilang</p>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white p-5 rounded-xl shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm text-netral-600">Kategori:</label>
                <select id="filterKategori" class="border rounded px-3 py-2 text-sm w-40">
                    <option value="all">Semua Kategori</option>
                    <option value="orang">Orang Hilang</option>
                    <option value="hewan">Hewan Hilang</option>
                    <option value="barang">Barang Hilang</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm text-netral-600">Dari:</label>
                <input type="date" id="startDate" class="border rounded px-3 py-2 text-sm">
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm text-netral-600">Sampai:</label>
                <input type="date" id="endDate" class="border rounded px-3 py-2 text-sm">
            </div>

            <button id="btnFilter" class="bg-primary text-white px-4 py-2 rounded text-sm hover:bg-primary-dark transition">
                <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>

            <button id="btnReset" class="bg-netral-200 text-netral-700 px-4 py-2 rounded text-sm hover:bg-netral-300 transition">
                Reset
            </button>
        </div>
    </div>

    {{-- DataTable Section --}}
    <div class="bg-white p-5 rounded-xl shadow-sm">
        <table id="reportsTable" class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">No</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Nama</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Kategori</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Tanggal Laporan</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('script')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let table = $('#reportsTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin.report') }}",
            data: function (d) {
                d.kategori = $('#filterKategori').val();
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'nama', name: 'nama'},
            {data: 'type', name: 'type'},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        pageLength: 10,
        order: [[3, 'desc']]
    });

    // Filter Button
    $('#btnFilter').click(function() {
        table.draw();
    });

    // Reset Button
    $('#btnReset').click(function() {
        $('#filterKategori').val('all');
        $('#startDate').val('');
        $('#endDate').val('');
        table.draw();
    });
});
</script>
@endpush