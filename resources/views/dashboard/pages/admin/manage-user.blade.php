@extends('dashboard.layouts.index')

@section('title', 'Manajemen User | InfoHilang Admin')

@section('content')

<div class="space-y-6" data-page="admin-manage-user">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-dark">Manajemen User</h1>
            <p class="text-sm text-netral-500 mt-1">Kelola semua user yang terdaftar di sistem</p>
        </div>
    </div>

    {{-- Filter Section --}}
    <div class="bg-white p-5 rounded-xl shadow-sm">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex items-center gap-2">
                <label class="text-sm text-netral-600">Dari Tanggal:</label>
                <input type="date" id="startDate" class="border rounded px-3 py-2 text-sm">
            </div>

            <div class="flex items-center gap-2">
                <label class="text-sm text-netral-600">Sampai Tanggal:</label>
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
        <table id="usersTable" class="w-full">
            <thead>
                <tr>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">No</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Nama</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Email</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Tanggal Daftar</th>
                    <th class="text-left py-3 px-4 text-sm font-semibold text-netral-700">Terakhir Update</th>
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
    let table = $('#usersTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: "{{ route('admin.user.ajax') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: function (d) {
                d.start_date = $('#startDate').val();
                d.end_date = $('#endDate').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'username', name: 'username'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
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
        $('#startDate').val('');
        $('#endDate').val('');
        table.draw();
    });
});
</script>
@endpush