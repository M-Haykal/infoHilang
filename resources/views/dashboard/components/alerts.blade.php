{{-- resources/views/components/alerts.blade.php --}}
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if ($errors->any())
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Form Tidak Valid',
                        icon: 'error',
                        html: `
                <ul class="text-left list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                        confirmButtonText: 'Perbaiki',
                        confirmButtonColor: '#ef4444'
                    });
                });
            @endif

            if (umur && isNaN(umur.value)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Input Tidak Valid',
                    text: 'Umur harus berupa angka.'
                });
                umur.focus();
                return;
            }

            // 🔸 Konfirmasi Hapus
            document.querySelectorAll('[data-confirm-save]').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const requiredFields = form.querySelectorAll('[required]');
                    let emptyFields = [];

                    requiredFields.forEach(field => {
                        if (!field.value || field.value.trim() === '') {
                            emptyFields.push(field);
                            field.classList.add('border-danger');
                        } else {
                            field.classList.remove('border-danger');
                        }
                    });

                    if (emptyFields.length > 0) {
                        Swal.fire({
                            title: 'Form Belum Lengkap',
                            text: 'Mohon lengkapi semua field yang wajib diisi.',
                            icon: 'warning',
                            confirmButtonText: 'Oke',
                            confirmButtonColor: '#f59e0b'
                        });

                        emptyFields[0].scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                        emptyFields[0].focus();
                        return;
                    }

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
                        if (result.isConfirmed) form.submit();
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
