<!-- Ciri-Ciri Khusus Dinamis -->
<div class="mb-6" data-characteristics>
    <label class="block text-sm font-semibold text-gray-700 mb-3">Ciri-Ciri Khusus</label>
    <div id="ciriCiriContainer" class="space-y-3">
        @if (!empty($ciriCiri))
            @foreach ($ciriCiri as $key => $value)
                <div class="flex flex-col sm:flex-row gap-2">
                    <input type="text" name="ciri_ciri_keys[]" value="{{ $key }}" placeholder="Nama ciri"
                        class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                    <div class="relative flex-1">
                        <input type="text" name="ciri_ciri_values[]" value="{{ $value }}"
                            placeholder="Deskripsi"
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
                <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                    class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <div class="relative flex-1">
                    <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
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

    <button type="button" class="mt-2 text-sm text-primary hover:underline" onclick="addCiriCiriField()">
        + Tambah Ciri-Ciri
    </button>
</div>
