<div class="mb-6">
    <label for="imageInput" class="block text-sm font-semibold text-gray-700 mb-2">Foto (Opsional)</label>
    <input type="file" id="imageInput" name="foto[]" accept="image/*" multiple
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">
    <p class="text-xs text-gray-500 mt-2">Maksimal 5 foto. Format: JPG, PNG, GIF.</p>

    <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4">
        {{-- Foto lama --}}
        {{-- Foto lama --}}
        @if (!empty($foto))
            @foreach ($foto as $path)
                <div class="relative group rounded-lg overflow-hidden shadow-md preview-existing"
                    data-path="{{ $path }}">
                    <img src="{{ asset('storage/' . $path) }}" alt="Foto Lama" class="w-full h-32 object-cover">
                    <button type="button"
                        class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 text-xs delete-existing-btn">
                        ×
                    </button>
                </div>
            @endforeach
        @endif
    </div>
</div>

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('imageInput');
            if (!imageInput) return;

            const previewContainer = document.getElementById('previewContainer');
            const form = imageInput.closest('form');
            const existingCount = {{ count($foto ?? []) }};
            let newFiles = [];

            previewContainer.addEventListener('click', function(e) {
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

                if (e.target.closest('.remove-new-btn')) {
                    const index = e.target.closest('.remove-new-btn').dataset.index;
                    newFiles.splice(index, 1);
                    updatePreview();
                }
            });

            function updatePreview() {
                document.querySelectorAll('.preview-new').forEach(el => el.remove());

                newFiles.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const div = document.createElement('div');
                        div.className = 'preview-new relative rounded-lg overflow-hidden shadow-md';
                        div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover" />
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

            imageInput.addEventListener('change', function() {
                const files = Array.from(this.files).filter(f => f.type.startsWith('image/'));
                if (files.length === 0) return;

                const existingVisible = document.querySelectorAll('.preview-existing').length;
                const total = existingVisible + newFiles.length + files.length;
                if (total > 5) {
                    alert('Maksimal total 5 foto.');
                    return;
                }

                newFiles.push(...files);
                updatePreview();
            });

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
