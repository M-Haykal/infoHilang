<!-- Kontak Darurat Dinamis -->
<div class="mb-6">
    <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat Lainnya</label>
    <div id="kontakContainer" class="space-y-3">
        <div class="flex flex-col sm:flex-row gap-2">
            <input type="text" name="kontak_keys[]" placeholder="Isikan jenis kontak"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat kontak"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>
        </div>
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
            <input type="text" name="kontak_keys[]" placeholder="Jenis kontak (misal: WhatsApp)"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat kontak"
                class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                onclick="removeField(this)">Hapus</button>
        `;
            container.appendChild(div);
        }
        
        @if (old('kontak_keys'))
            const kontakKeys = {!! json_encode(old('kontak_keys')) !!};
            const kontakVals = {!! json_encode(old('kontak_values')) !!};
            const kontakContainer = document.getElementById('kontakContainer');
            kontakContainer.innerHTML = '';
            kontakKeys.forEach((key, i) => {
                const div = document.createElement('div');
                div.className = 'flex flex-col sm:flex-row gap-2';
                div.innerHTML = `
                    <input type="text" name="kontak_keys[]" value="${key}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <input type="text" name="kontak_values[]" value="${kontakVals[i] ?? ''}"
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <button type="button" class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600"
                        onclick="removeField(this)">Hapus</button>
                `;
                kontakContainer.appendChild(div);
            });
        @endif
    </script>
@endpush
