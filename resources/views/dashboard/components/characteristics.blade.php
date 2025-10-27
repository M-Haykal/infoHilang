<!-- Ciri-Ciri Khusus Dinamis -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-3">Ciri-Ciri Khusus Lainnya</label>
    <div id="ciriCiriContainer" class="space-y-3">
        <!-- Input awal (opsional) -->
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri (misal: Tato)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi (misal: Tato naga di lengan kiri)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>
        </div>
    </div>
    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addCiriCiriField()">
        + Tambah Ciri-Ciri
    </button>
</div>

@push('script')
    <script>
        // Tambah field Ciri-Ciri
        function addCiriCiriField() {
            const container = document.getElementById('ciriCiriContainer');
            const div = document.createElement('div');
            div.className = 'flex flex-col sm:flex-row gap-2';
            div.innerHTML = `
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri (misal: Tato)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi (misal: Tato naga di lengan kiri)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                onclick="removeField(this)">Hapus</button>
        `;
            container.appendChild(div);
        }
        
        // Isi ulang Ciri-Ciri dari old input
        @if (old('ciri_ciri_keys'))
            const ciriKeys = {!! json_encode(old('ciri_ciri_keys')) !!};
            const ciriVals = {!! json_encode(old('ciri_ciri_values')) !!};
            const ciriContainer = document.getElementById('ciriCiriContainer');
            ciriContainer.innerHTML = '';
            ciriKeys.forEach((key, i) => {
                const div = document.createElement('div');
                div.className = 'flex flex-col sm:flex-row gap-2';
                div.innerHTML = `
                    <input type="text" name="ciri_ciri_keys[]" value="${key}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <input type="text" name="ciri_ciri_values[]" value="${ciriVals[i] ?? ''}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                        onclick="removeField(this)">Hapus</button>
                `;
                ciriContainer.appendChild(div);
            });
        @endif
    </script>
@endpush
