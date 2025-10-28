<!-- Kontak Darurat Dinamis -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat Lainnya</label>
    <div id="kontakContainer" class="space-y-3">
        @if (!empty($kontak))
            @foreach ($kontak as $key => $value)
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="kontak_keys[]" value="{{ $key }}" placeholder="Jenis kontak"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <input type="text" name="kontak_values[]" value="{{ $value }}"
                        placeholder="Nomor atau alamat"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                        onclick="removeField(this)">Hapus</button>
                </div>
            @endforeach
        @else
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                    onclick="removeField(this)">Hapus</button>
            </div>
        @endif
    </div>

    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addKontakField()">
        + Tambah Kontak
    </button>
</div>

@push('script')
    <script>
        function addKontakField() {
            const container = document.getElementById('kontakContainer');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
            <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>`;
            container.appendChild(div);
        }
    </script>
@endpush
