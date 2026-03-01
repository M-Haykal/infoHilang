@php
    $max = $max ?? 5;
    $isMultiple = $multiple ?? true;
    $id = $id ?? 'imageInput';
@endphp

<div class="mb-6" data-photo-upload data-max="{{ $max }}" data-multiple="{{ $isMultiple ? 'true' : 'false' }}">
    <div class="mb-2">
        <label for="{{ $id }}" class="block text-sm font-semibold text-dark mb-2">
            Foto (Opsional)
        </label>

        <input type="file" id="{{ $id }}" name="foto[]" accept="image/*"
            {{ $isMultiple ? 'multiple' : '' }}
            class="block w-full text-sm text-netral-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">

        <p class="text-xs text-netral-500 mt-2">{{ !$isMultiple ? 'Maksimal 1 foto' : 'Maksimal ' . $max . ' foto' }}. Format: JPG, PNG, GIF.</p>
    </div>

    <div id="previewContainer-{{ $id }}" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4 mb-2">
        @if (!empty($foto))
            @foreach ($foto as $path)
                <div class="relative group rounded-xl shadow-sm border border-netral-200 preview-existing bg-netral-50 overflow-hidden isolate" data-path="{{ $path }}">
                    <img src="{{ asset('storage/' . $path) }}" class="w-full h-24 object-cover group-hover:scale-110 transition-all">
                    <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                    <button type="button" class="absolute top-2 right-2 bg-danger text-white rounded-lg hover:bg-danger-dark transition-colors shadow-lg w-7 h-7 flex items-center justify-center delete-existing-btn z-10">
                        <i class="fa-solid fa-trash-can text-[10px]"></i>
                    </button>
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
    const containers = document.querySelectorAll('[data-photo-upload]');

    containers.forEach(container => {
        const imageInput = container.querySelector('input[type="file"]');
        const previewContainer = container.querySelector('[id^="previewContainer"]');
        const maxFiles = parseInt(container.dataset.max);
        const isMultiple = container.dataset.multiple === 'true';
        const form = imageInput.closest('form');
        let newFiles = [];

        function renderNewFilesPreview() {
            container.querySelectorAll('.preview-new').forEach(el => el.remove());

            newFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = e => {
                    const div = document.createElement('div');
                    div.className = 'preview-new relative group rounded-xl overflow-hidden shadow-sm border border-netral-200 h-24 isolate';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" />

                        <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

                        <button type="button" data-index="${index}"
                            class="absolute top-2 right-2 bg-danger text-white rounded-lg w-7 h-7 flex items-center justify-center hover:bg-danger-dark transition-colors shadow-lg remove-new-btn z-10">
                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                        </button>`;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        imageInput.addEventListener('change', function() {
            const selectedFiles = Array.from(this.files).filter(f => f.type.startsWith('image/'));
            const existingVisible = container.querySelectorAll('.preview-existing').length;

            if (!isMultiple) {
                // Jika cuma 1 foto, replace file lama
                newFiles = selectedFiles.slice(0, 1);
            } else {
                if (existingVisible + newFiles.length + selectedFiles.length > maxFiles) {
                    alert(`Maksimal total ${maxFiles} foto.`);
                    this.value = "";
                    return;
                }
                newFiles = [...newFiles, ...selectedFiles];
            }

            renderNewFilesPreview();
            this.value = "";
        });

        // Event Delegation untuk hapus
        previewContainer.addEventListener('click', e => {
            if (e.target.closest('.remove-new-btn')) {
                const index = e.target.closest('.remove-new-btn').dataset.index;
                newFiles.splice(index, 1);
                renderNewFilesPreview();
            }

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
        });

        form.addEventListener('submit', () => {
            const dt = new DataTransfer();
            newFiles.forEach(file => dt.items.add(file));
            imageInput.files = dt.files;
        });
    });
});
</script>
@endpush
