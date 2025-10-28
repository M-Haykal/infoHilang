<!-- Ciri-Ciri Khusus Dinamis -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-3">Ciri-Ciri Khusus Lainnya</label>
    <div id="ciriCiriContainer" class="space-y-3">
        @if (!empty($ciriCiri))
            @foreach ($ciriCiri as $key => $value)
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="ciri_ciri_keys[]" value="{{ $key }}" placeholder="Nama ciri"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <input type="text" name="ciri_ciri_values[]" value="{{ $value }}" placeholder="Deskripsi"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                        onclick="removeField(this)">Hapus</button>
                </div>
            @endforeach
        @else
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                    onclick="removeField(this)">Hapus</button>
            </div>
        @endif
    </div>

    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addCiriCiriField()">
        + Tambah Ciri-Ciri
    </button>
</div>

@push('script')
    <script>
        function addCiriCiriField() {
            const container = document.getElementById('ciriCiriContainer');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>`;
            container.appendChild(div);
        }
    </script>
@endpush
