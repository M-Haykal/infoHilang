<div class="mb-6" data-documents>
    <label for="documentInput" class="block text-sm font-semibold text-gray-700 mb-2">Dokumen Pendukung (Opsional)</label>
    <input type="file" id="documentInput" name="document_pendukung[]" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" multiple
        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-800 cursor-pointer">
    <p class="text-xs text-gray-500 mt-2">Maksimal 3 file. Format: PDF, DOC, DOCX, JPG, PNG.</p>

    <div id="documentPreviewContainer" class="flex flex-wrap gap-3 mt-4">
        {{-- Dokumen lama (dari database) --}}
        @if (!empty($document_pendukung))
            @foreach ($document_pendukung as $path)
                <div class="relative group bg-white border rounded-lg p-3 flex items-center w-48 shadow-sm">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3 truncate">
                        <p class="text-xs font-medium text-gray-800">
                            {{ basename($path) }}
                        </p>
                        <p class="text-xs text-gray-500">
                            {{ \Storage::disk('public')->exists($path) ? (\Storage::disk('public')->size($path) / 1024 < 1024 ? round(\Storage::disk('public')->size($path) / 1024, 1) . ' KB' : round(\Storage::disk('public')->size($path) / (1024 * 1024), 1) . ' MB') : '–' }}
                        </p>
                    </div>
                    <button type="button"
                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 text-xs delete-existing-doc-btn"
                        data-path="{{ $path }}">
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
            const docInput = document.getElementById('documentInput');
            const previewContainer = document.getElementById('documentPreviewContainer');
            const form = docInput.closest('form');
            const existingDocs = @json($document_pendukung ?? []);
            let newFiles = [];

            // ============================
            //  FUNGSI BUKA PREVIEW TAB BARU
            // ============================
            function openInNewTab(url, filename) {
                const ext = filename.split('.').pop().toLowerCase();

                if (ext === "pdf" || ["jpg", "jpeg", "png"].includes(ext)) {
                    window.open(url, "_blank");
                } else if (["doc", "docx"].includes(ext)) {
                    const gview = `https://docs.google.com/gview?url=${encodeURIComponent(url)}&embedded=true`;
                    window.open(gview, "_blank");
                } else {
                    window.open(url, "_blank");
                }
            }

            // ============================
            // HAPUS FILE LAMA & BARU
            // ============================
            previewContainer.addEventListener("click", function(e) {
                // Hapus file lama
                if (e.target.closest(".delete-existing-doc-btn")) {
                    const btn = e.target.closest(".delete-existing-doc-btn");
                    const path = btn.dataset.path;

                    const hidden = document.createElement('input');
                    hidden.type = 'hidden';
                    hidden.name = 'deleted_document[]';
                    hidden.value = path;
                    form.appendChild(hidden);

                    btn.closest('.group').remove();
                    return;
                }

                // Hapus file baru
                if (e.target.closest(".remove-new-doc-btn")) {
                    const index = e.target.closest(".remove-new-doc-btn").dataset.index;
                    newFiles.splice(index, 1);
                    updateDocPreview();
                    return;
                }

                // =====================================
                //  PREVIEW FILE LAMA → TAB BARU
                // =====================================
                const box = e.target.closest(".group");
                if (box && box.querySelector(".delete-existing-doc-btn")) {
                    const filename = box.querySelector("p.text-xs.font-medium").innerText.trim();
                    const filepath = box.querySelector(".delete-existing-doc-btn").dataset.path;
                    const url = `/storage/${filepath}`;

                    openInNewTab(url, filename);
                }
            });

            // ============================
            //  PREVIEW FILE BARU DI LIST
            // ============================
            function updateDocPreview() {
                document.querySelectorAll('.preview-new-doc').forEach(el => el.remove());

                newFiles.forEach((file, index) => {
                    const div = document.createElement("div");
                    div.className =
                        "preview-new-doc relative bg-white border rounded-lg p-3 flex items-center w-48 shadow-sm cursor-pointer";

                    const icon = file.type.includes('pdf') ?
                        '📄' :
                        file.type.includes('word') ? '📘' : '🖼️';

                    div.innerHTML = `
                <div class="flex-shrink-0 w-10 h-10 bg-gray-100 rounded flex items-center justify-center text-lg">
                    ${icon}
                </div>
                <div class="ml-3 truncate">
                    <p class="text-xs font-medium text-gray-800">${file.name}</p>
                    <p class="text-xs text-gray-500">${(file.size / 1024).toFixed(1)} KB</p>
                </div>
                <button type="button" data-index="${index}"
                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 text-xs remove-new-doc-btn">
                    ×
                </button>
            `;

                    // Klik file baru → preview TAB BARU
                    div.addEventListener("click", function(e) {
                        if (e.target.closest(".remove-new-doc-btn"))
                    return; // agar tombol remove tetap berfungsi

                        const blobUrl = URL.createObjectURL(file);
                        openInNewTab(blobUrl, file.name);
                    });

                    previewContainer.appendChild(div);
                });
            }

            // ============================
            //  HANDLE INPUT FILE BARU
            // ============================
            docInput.addEventListener("change", function() {
                const files = Array.from(this.files);

                // Maksimal total 3 file
                const total = existingDocs.length + newFiles.length + files.length;
                if (total > 3) {
                    alert("Maksimal 3 dokumen.");
                    return;
                }

                newFiles.push(...files);
                updateDocPreview();

                // Buka preview otomatis file pertama
                const firstFile = files[0];
                if (firstFile) {
                    const blobUrl = URL.createObjectURL(firstFile);
                    openInNewTab(blobUrl, firstFile.name);
                }
            });

            // ============================
            //  INSERT FILE BARU SAAT SUBMIT
            // ============================
            if (form) {
                form.addEventListener('submit', function() {
                    const dt = new DataTransfer();
                    newFiles.forEach(file => dt.items.add(file));
                    docInput.files = dt.files;
                });
            }
        });
    </script>
@endpush
