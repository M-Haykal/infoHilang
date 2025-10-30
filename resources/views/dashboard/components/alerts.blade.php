{{-- resources/views/components/alerts.blade.php --}}
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 🔸 Konfirmasi Hapus
            document.querySelectorAll('[data-confirm-delete]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Hapus Laporan?',
                        text: "Data ini akan dihapus permanen dan tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) this.submit();
                    });
                });
            });

            // 🔸 Konfirmasi Simpan
            document.querySelectorAll('[data-confirm-save]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Simpan Data?',
                        text: "Apakah Anda yakin ingin menyimpan data ini?",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#10b981',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) this.submit();
                    });
                });
            });

            // 🔸 Konfirmasi Edit
            document.querySelectorAll('[data-confirm-edit]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;
                    Swal.fire({
                        title: 'Edit Laporan?',
                        text: "Anda akan dialihkan ke halaman edit. Lanjutkan?",
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Edit!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) window.location.href = url;
                    });
                });
            });

            // 🔸 Konfirmasi Umum (untuk tombol/tindakan kustom)
            document.querySelectorAll('[data-confirm-action]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const title = this.dataset.title || 'Konfirmasi';
                    const text = this.dataset.text || 'Apakah Anda yakin?';
                    const confirmText = this.dataset.confirmText || 'Ya, Lanjutkan!';
                    const cancelText = this.dataset.cancelText || 'Batal';
                    const icon = this.dataset.icon || 'question';
                    const actionUrl = this.dataset.action;

                    Swal.fire({
                        title: title,
                        text: text,
                        icon: icon,
                        showCancelButton: true,
                        confirmButtonColor: '#3b82f6',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: confirmText,
                        cancelButtonText: cancelText
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (actionUrl) {
                                window.location.href = actionUrl;
                            } else if (this.tagName === 'BUTTON' && this.form) {
                                this.form.submit();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush
