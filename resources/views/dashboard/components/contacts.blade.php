{{--
    Kontak Darurat (field dinamis).
    Parameter opsional:
      - $kontak    : array [jenis => nilai]
      - $types     : array [value => label]. Bila diisi, kolom "jenis kontak" memakai <select>.
                     Bila tidak diisi, tetap memakai input teks (kompatibel dgn form laporan).
      - $showLabel : bool, default true. Set false bila judul sudah dibuat oleh pemanggil.
      - $hint      : string|null, deskripsi singkat di bawah judul.
--}}
@php
    $kontak = $kontak ?? [];
    $types = $types ?? null;
    $showLabel = $showLabel ?? true;
    $hint = $hint ?? null;
    $rows = !empty($kontak) ? $kontak : ['' => ''];
@endphp

<div data-contacts class="{{ $showLabel ? 'mb-6' : '' }}">
    @if ($showLabel)
        <label class="block text-sm font-semibold text-dark mb-3">Kontak Darurat Tambahan</label>
    @endif

    @if (!empty($hint))
        <p class="text-xs text-netral-400 mb-3 flex items-start gap-2">
            <i class="fa-solid fa-circle-info mt-0.5 text-netral-300"></i>
            <span>{{ $hint }}</span>
        </p>
    @endif

    <div id="kontakContainer" class="space-y-3" @if ($types) data-kontak-types='{{ json_encode($types) }}' @endif>
        @foreach ($rows as $key => $value)
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                @if ($types)
                    <select name="kontak_keys[]"
                        class="px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-netral-50 text-sm transition-all outline-none">
                        <option value="">Pilih jenis kontak</option>
                        @foreach ($types as $typeValue => $typeLabel)
                            <option value="{{ $typeValue }}" @selected((string) $key === (string) $typeValue)>
                                {{ $typeLabel }}</option>
                        @endforeach
                        {{-- Pertahankan nilai lama yang belum ada di daftar jenis --}}
                        @if ($key !== '' && !array_key_exists($key, $types))
                            <option value="{{ $key }}" selected>{{ $key }}</option>
                        @endif
                    </select>
                @else
                    <input type="text" name="kontak_keys[]" value="{{ $key }}" placeholder="Jenis kontak"
                        class="px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                @endif

                <div class="relative">
                    <input type="text" name="kontak_values[]" value="{{ $value }}"
                        placeholder="Nomor atau alamat"
                        class="w-full px-4 py-3 pr-11 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-netral-50 text-sm transition-all outline-none">
                    <button type="button" title="Hapus kontak"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-1.5 rounded-lg text-netral-400 hover:text-danger hover:bg-danger-light transition-colors"
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
    </div>

    <button type="button" class="mt-3 text-sm text-primary hover:underline font-medium" onclick="addKontakField()">
        <i class="fa-solid fa-plus mr-1"></i> Tambah Kontak
    </button>

    @push('script')
        <script src="{{ asset('js/dashboard/dynamic-fields.js') }}"></script>
    @endpush
</div>
