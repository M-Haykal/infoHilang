<div class="mb-6" data-photo-upload>
    <div class="mb-2">
        <label for="imageInput" class="block text-sm font-semibold text-dark mb-2">Foto (Opsional)</label>
        <input type="file" id="imageInput" name="foto[]" accept="image/*" multiple class="block w-full text-sm text-netral-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">
        <p class="text-xs text-netral-500 mt-2">Maksimal 5 foto. Format: JPG, PNG, GIF.</p>
    </div>

    <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        {{-- Foto lama --}}
        @if (!empty($foto))
        @foreach ($foto as $path)
        <div class="relative group rounded-xl overflow-hidden shadow-sm border border-netral-100 preview-existing bg-netral-50" data-path="{{ $path }}">

            {{-- Gambar dengan fallback error --}}
            <img src="{{ asset('storage/' . $path) }}" alt="Foto Lama" class="w-full h-32 object-cover transition-transform duration-500 group-hover:scale-110" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

            {{-- Placeholder kalau file fisik hilang --}}
            <div class="hidden w-full h-32 bg-netral-100 flex-col items-center justify-center text-netral-400">
                <i class="fa-solid fa-file-circle-exclamation text-xl mb-1"></i>
                <span class="text-[8px] font-bold uppercase tracking-tighter">File Missing</span>
            </div>

            {{-- Overlay & tombol hapus --}}
            <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <button type="button" class="absolute top-2 right-2 bg-danger text-white rounded-lg w-7 h-7 flex items-center justify-center hover:bg-danger-dark transition-colors shadow-lg delete-existing-btn z-10" title="Hapus Foto">
                <i class="fa-solid fa-trash-can text-[10px]"></i>
            </button>

            {{-- Label path --}}
            <div class="absolute bottom-0 inset-x-0 bg-white/90 backdrop-blur-sm py-1 px-2 translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                <p class="text-[8px] text-netral-500 truncate font-mono">{{ $path }}</p>
            </div>
        </div>
        @endforeach
        @endif
    </div>

    <div class="bg-accent-surface border border-accent rounded-lg p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fa-solid fa-circle-exclamation text-accent"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-bold text-accent">Tips Pelaporan</h3>
                <p class="text-sm text-accent mt-1">
                    Foto kualitas tinggi sangat membantu. Hindari foto buram, gelap, atau terlalu jauh.
                </p>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');
        if (!imageInput || !previewContainer) return;

        const form = imageInput.closest('form');
        let newFiles = []; // Nampung file baru

        // Untuk render ulang preview khusus file baru
        function renderNewFilesPreview() {
            // Hapus semua preview baru yang lama supaya ga duplikat
            document.querySelectorAll('.preview-new').forEach(el => el.remove());

            newFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'preview-new relative rounded-lg overflow-hidden shadow-sm mb-3';
                    div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-16 object-cover" />
                    <button type="button" data-index="${index}"
                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 text-xs remove-new-btn">
                        ×
                    </button>
                `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        // Event Listener untuk tombol hapus (Delegation)
        previewContainer.addEventListener('click', function(e) {
            // Hapus loto Lama (Existing)
            if (e.target.closest('.delete-existing-btn')) {
                const previewDiv = e.target.closest('.preview-existing');
                const path = previewDiv.dataset.path;

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'deleted_foto[]';
                hiddenInput.value = path;
                form.appendChild(hiddenInput);

                previewDiv.remove();
            }

            // Hapus foto baru (yang baru di-upload)
            if (e.target.closest('.remove-new-btn')) {
                const btn = e.target.closest('.remove-new-btn');
                const index = btn.dataset.index;
                newFiles.splice(index, 1); // Hapus dari array
                renderNewFilesPreview(); // Render ulang
            }
        });

        // Event saat pilih file
        imageInput.addEventListener('change', function() {
            const selectedFiles = Array.from(this.files).filter(f => f.type.startsWith('image/'));

            const existingVisible = document.querySelectorAll('.preview-existing').length;
            if (existingVisible + newFiles.length + selectedFiles.length > 5) {
                alert('Maksimal total 5 foto.');
                this.value = ""; // Reset input file browser
                return;
            }

            // Gabung file baru ke array penampung
            newFiles = [...newFiles, ...selectedFiles];
            renderNewFilesPreview();

            // Reset input file supaya bisa pilih file yang sama kalau habis dihapus
            this.value = "";
        });

        // Saat Submit: Pindahin semua file dari array ke Input File asli
        if (form) {
            form.addEventListener('submit', function() {
                const dt = new DataTransfer();
                newFiles.forEach(file => dt.items.add(file));
                imageInput.files = dt.files;
            });
        }
    });

</script>
@endpush
