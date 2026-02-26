<!-- Ciri-Ciri Khusus Dinamis -->
<div class="my-6" data-characteristics>
    <label class="block text-sm font-semibold text-dark mb-3">Ciri-Ciri Khusus Tambahan</label>
    <div id="ciriCiriContainer" class="space-y-3">
        @if (!empty($ciriCiri))
            @foreach ($ciriCiri as $key => $value)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                    <input type="text" name="ciri_ciri_keys[]" value="{{ $key }}" placeholder="Nama ciri"
                        class="px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    <div class="relative">
                        <input type="text" name="ciri_ciri_values[]" value="{{ $value }}"
                            placeholder="Deskripsi"
                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        <button type="button"
                            class="absolute right-2 top-1/2 -translate-y-1/2 text-netral-400 hover:text-danger"
                            onclick="removeField(this.closest('.grid'))">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                <div class="relative w-full">
                    <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                    <button type="button"
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-netral-400 hover:text-danger"
                        onclick="removeField(this.closest('.grid'))">
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

    @push('script')
        <script src="{{ asset('js/dashboard/dynamic-fields.js') }}"></script>
    @endpush
</div>
