<!-- Kontak Darurat Dinamis -->
<div class="mb-6" data-contacts>
    <label class="block text-sm font-semibold text-gray-700 mb-3">Kontak Darurat Tambahan</label>
    <div id="kontakContainer" class="space-y-3">
        @if (!empty($kontak))
            @foreach ($kontak as $key => $value)
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="kontak_keys[]" value="{{ $key }}" placeholder="Jenis kontak"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <div class="relative flex-1">
                        <input type="text" name="kontak_values[]" value="{{ $value }}"
                            placeholder="Nomor atau alamat"
                            class="w-full px-3 py-2 pl-3 pr-8 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                        <button type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger"
                            onclick="removeField(this.closest('.flex'))">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endforeach
        @else
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <div class="relative flex-1">
                    <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                        class="w-full px-3 py-2 pl-3 pr-8 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <button type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger"
                        onclick="removeField(this.closest('.flex'))">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>

    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addKontakField()">
        + Tambah Kontak
    </button>
</div>
