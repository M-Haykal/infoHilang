<div class="mb-6">
    <label for="imageInput" class="block text-sm font-semibold text-gray-700 mb-2">Foto
        (Opsional)</label>
    <input type="file" id="imageInput" name="foto[]" accept="image/*" multiple
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-blue-700 cursor-pointer">
    <p class="text-xs text-gray-500 mt-2">Maksimal 5 foto. Format: JPG, PNG, GIF.</p>
    <div id="previewContainer" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-4"></div>
</div>

@push('script')
    <script>
        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');

        function updatePreview(files) {
            previewContainer.innerHTML = '';
            if (files.length === 0) return;

            files.forEach((file, index) => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const previewDiv = document.createElement('div');
                        previewDiv.className =
                            'relative group rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-32 object-cover';
                        img.alt = `Preview ${index + 1}`;

                        const overlay = document.createElement('div');
                        overlay.className =
                            'absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity duration-300 flex items-center justify-center';

                        const deleteButton = document.createElement('button');
                        deleteButton.className =
                            'opacity-0 group-hover:opacity-100 bg-danger text-white rounded-full w-8 h-8 flex items-center justify-center hover:bg-red-600 transition-opacity duration-300';
                        deleteButton.innerHTML = '&times;';
                        deleteButton.title = 'Hapus';
                        deleteButton.addEventListener('click', () => {
                            previewDiv.remove();
                            const newFiles = new DataTransfer();
                            Array.from(imageInput.files)
                                .filter((_, i) => i !== index)
                                .forEach(f => newFiles.items.add(f));
                            imageInput.files = newFiles.files;
                            updatePreview(Array.from(imageInput.files));
                        });

                        overlay.appendChild(deleteButton);
                        previewDiv.appendChild(img);
                        previewDiv.appendChild(overlay);
                        previewContainer.appendChild(previewDiv);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }

        imageInput.addEventListener('change', function() {
            updatePreview(Array.from(this.files));
        });
    </script>
@endpush
