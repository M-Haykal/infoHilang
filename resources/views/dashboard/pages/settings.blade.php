@extends('dashboard.layouts.index')

@section('title', 'Pengaturan Akun | InfoHilang')

@section('content')
    @php
        // Daftar tab. Untuk menambah tab baru (mis. Notifikasi / Riwayat Laporan),
        // cukup tambahkan satu entri di sini + blok #tab-<id> di bawah.
        $tabs = [
            ['id' => 'profile', 'label' => 'Profil Umum', 'icon' => 'fa-solid fa-user'],
            ['id' => 'security', 'label' => 'Keamanan', 'icon' => 'fa-solid fa-shield-halved'],
        ];

        $emailVerified = !empty($user->email_verified_at);
        $waValue = old('phone', $user->phone ?? '');
        $waFilled = trim((string) $waValue) !== '';
    @endphp

    <div class="space-y-6">
        {{-- ============ HEADER ============ --}}
        <div class="p-1">
            <h1 class="text-2xl sm:text-3xl font-bold text-dark">Pengaturan Akun</h1>
            <p class="text-xs font-medium text-netral-400 mt-2">Kelola informasi profil dan keamanan akun Anda.</p>
        </div>

        {{-- ============ ALERTS ============ --}}
        @if (session('success'))
            <div class="p-4 bg-success text-white rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check"></i>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-4 bg-danger-light text-danger rounded-xl border border-danger/20 flex items-start gap-3">
                <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                <div class="text-sm">
                    <p class="font-bold">Ada {{ $errors->count() }} data yang perlu diperbaiki.</p>
                    <p class="text-danger/80 mt-0.5">Silakan periksa kembali kolom yang ditandai di bawah.</p>
                </div>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-6 lg:gap-8">
            {{-- ============ SIDEBAR NAVIGATION CARD ============ --}}
            <aside class="w-full lg:w-64 shrink-0">
                <div
                    class="lg:bg-white lg:border lg:border-netral-100 lg:rounded-2xl lg:p-3 lg:shadow-sm lg:sticky lg:top-6">
                    <p class="hidden lg:block px-3 pt-1 pb-3 text-[11px] font-bold uppercase tracking-wider text-netral-400">
                        Pengaturan
                    </p>
                    <nav
                        class="no-scrollbar flex lg:flex-col gap-2 overflow-x-auto lg:overflow-visible pb-1 lg:pb-0 -mx-1 px-1 lg:mx-0 lg:px-0">
                        @foreach ($tabs as $tab)
                            <button type="button" onclick="switchTab('{{ $tab['id'] }}')" id="btn-{{ $tab['id'] }}"
                                class="tab-btn whitespace-nowrap shrink-0 lg:w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm text-netral-500 hover:bg-netral-100 hover:text-dark">
                                <i class="{{ $tab['icon'] }} w-4 text-center"></i>
                                <span>{{ $tab['label'] }}</span>
                            </button>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- ============ CONTENT AREA ============ --}}
            <div class="flex-1 min-w-0">

                {{-- ================= TAB: PROFIL UMUM ================= --}}
                <div id="tab-profile" class="settings-content space-y-6">

                    {{-- Kartu header profil (avatar horizontal) --}}
                    <div class="bg-white border border-netral-100 rounded-2xl p-5 sm:p-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-left">
                            <div class="relative group shrink-0">
                                @if (!empty($user->avatar))
                                    <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg ring-1 ring-netral-100">
                                @else
                                    <div id="avatarPreview"
                                        class="w-24 h-24 rounded-full bg-gradient-to-br from-netral-100 to-netral-200 flex items-center justify-center text-netral-400 border-4 border-white shadow-lg ring-1 ring-netral-100">
                                        <i class="fa-solid fa-user text-3xl"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 rounded-full bg-dark/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer"
                                    onclick="document.getElementById('avatarInput').click()">
                                    <i class="fa-solid fa-camera text-white"></i>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0">
                                <h2 class="text-lg font-bold text-dark truncate">
                                    {{ $user->fullname ?? $user->username }}
                                </h2>
                                <p class="text-sm text-netral-400 truncate">{{ '@' . $user->username }}</p>

                                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2 mt-3">
                                    <button type="button" onclick="document.getElementById('avatarInput').click()"
                                        class="px-4 py-2 bg-primary-light text-primary rounded-lg text-sm font-semibold hover:bg-primary hover:text-white transition-colors">
                                        <i class="fa-solid fa-upload mr-2"></i>Ganti Foto
                                    </button>
                                    @if (!empty($user->avatar))
                                        <button type="button" id="removeAvatarBtn"
                                            class="px-4 py-2 bg-danger-light text-danger rounded-lg text-sm font-semibold hover:bg-danger hover:text-white transition-colors">
                                            <i class="fa-solid fa-trash mr-2"></i>Hapus
                                        </button>
                                    @endif
                                </div>
                                <p class="text-xs text-netral-400 mt-3">Format JPG, JPEG, PNG · Maksimal 2MB</p>
                            </div>
                        </div>
                    </div>

                    {{-- Input avatar diletakkan di luar form lalu diikat lewat atribut form="profileForm" --}}
                    <input id="avatarInput" type="file" name="avatar" accept="image/*" class="hidden" form="profileForm">
                    <input type="hidden" id="remove_avatar" name="remove_avatar" value="0" form="profileForm">

                    <form id="profileForm" action="{{ route('settings.profile.update') }}" method="POST"
                        enctype="multipart/form-data" class="space-y-6">
                        @csrf @method('PUT')

                        {{-- ---------- Kartu: Informasi Pribadi ---------- --}}
                        <div class="bg-white border border-netral-100 rounded-2xl p-5 sm:p-6 shadow-sm">
                            <div class="mb-5">
                                <h3 class="text-base font-bold text-dark flex items-center gap-2">
                                    <i class="fa-solid fa-address-card text-primary"></i> Informasi Pribadi
                                </h3>
                                <p class="text-xs text-netral-400 mt-1">Data ini dipakai untuk mengidentifikasi Anda pada
                                    setiap laporan.</p>
                            </div>

                            {{-- Baris 1: Nama Lengkap | Username  •  Baris 2: Email | Nomor WhatsApp --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                {{-- Nama Lengkap --}}
                                <div class="space-y-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-id-card text-netral-400 text-xs"></i> Nama Lengkap
                                    </label>
                                    <input type="text" name="fullname"
                                        value="{{ old('fullname', $user->fullname ?? '') }}"
                                        placeholder="Masukkan nama lengkap"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('fullname') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                    @error('fullname')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Username --}}
                                <div class="space-y-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-at text-netral-400 text-xs"></i> Username
                                    </label>
                                    <input type="text" name="username"
                                        value="{{ old('username', $user->username ?? '') }}"
                                        placeholder="Username unik"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('username') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                    @error('username')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Alamat Email (dengan badge status) --}}
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-envelope text-netral-400 text-xs"></i> Alamat Email
                                        </label>
                                        @if ($emailVerified)
                                            <span
                                                class="inline-flex items-center gap-1 text-[10px] font-bold text-success bg-success-light px-2 py-0.5 rounded-full">
                                                <i class="fa-solid fa-circle-check"></i> Terverifikasi
                                            </span>
                                        @else
                                            <div class="flex items-center gap-2">
                                                <span
                                                    class="inline-flex items-center gap-1 text-[10px] font-bold text-accent-hover bg-accent-surface px-2 py-0.5 rounded-full">
                                                    <i class="fa-solid fa-circle-exclamation"></i> Belum diverifikasi
                                                </span>
                                                <button type="button" onclick="openOtpModal()"
                                                    class="inline-flex items-center gap-1 text-[10px] font-bold text-primary bg-primary-light px-2 py-0.5 rounded-full hover:bg-primary hover:text-white transition-colors">
                                                    <i class="fa-solid fa-paper-plane"></i> Verifikasi
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="email" name="email"
                                        value="{{ old('email', $user->email ?? '') }}"
                                        placeholder="email@contoh.com"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('email') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                    @error('email')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Nomor WhatsApp (dengan badge status) --}}
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between gap-2">
                                        <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                            <i class="fa-brands fa-whatsapp text-netral-400 text-sm"></i> Nomor WhatsApp
                                        </label>
                                        @if ($waFilled)
                                            <span
                                                class="inline-flex items-center gap-1 text-[10px] font-bold text-success bg-success-light px-2 py-0.5 rounded-full">
                                                <i class="fa-solid fa-circle-check"></i> Aktif
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 text-[10px] font-bold text-netral-500 bg-netral-100 px-2 py-0.5 rounded-full">
                                                <i class="fa-solid fa-circle-minus"></i> Belum diisi
                                            </span>
                                        @endif
                                    </div>
                                    <input type="text" name="phone" value="{{ $waValue }}"
                                        placeholder="08123456789"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('phone') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                    @error('phone')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="space-y-2 md:col-span-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-location-dot text-netral-400 text-xs"></i> Alamat
                                    </label>
                                    <textarea name="alamat" rows="3" placeholder="Masukkan alamat lengkap Anda"
                                        class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none resize-none @error('alamat') border-danger focus:border-danger focus:ring-danger/20 @enderror">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                    @error('alamat')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ---------- Kartu: Kontak Darurat ---------- --}}
                        <div class="bg-white border border-netral-100 rounded-2xl p-5 sm:p-6 shadow-sm">
                            <div class="mb-4">
                                <h3 class="text-base font-bold text-dark flex items-center gap-2">
                                    <i class="fa-solid fa-phone-volume text-accent"></i> Kontak Darurat
                                </h3>
                                <p class="text-xs text-netral-400 mt-1 flex items-start gap-2">
                                    <i class="fa-solid fa-circle-info mt-0.5 text-netral-300"></i>
                                    <span>Kontak ini akan dihubungi jika barang milik Anda ditemukan namun Anda tidak
                                        dapat dihubungi melalui WhatsApp utama.</span>
                                </p>
                            </div>

                            @include('dashboard.components.contacts', [
                                'kontak' => old('kontak', $kontak ?? []),
                                'types' => $contactTypes ?? [],
                                'showLabel' => false,
                            ])
                        </div>

                        {{-- ---------- Tombol Simpan (sticky di mobile) ---------- --}}
                        <div class="sticky bottom-0 z-30 md:static">
                            <div
                                class="flex justify-end rounded-2xl md:rounded-none p-3 md:p-0 border border-netral-100 md:border-0 bg-white/95 backdrop-blur-sm md:bg-transparent md:backdrop-blur-none shadow-lg md:shadow-none md:pt-6 md:border-t md:border-netral-100">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- ================= TAB: KEAMANAN ================= --}}
                <div id="tab-security" class="settings-content hidden space-y-6">
                    <form action="{{ route('settings.password.update') }}" method="POST" class="space-y-6">
                        @csrf @method('PUT')

                        <div class="bg-white border border-netral-100 rounded-2xl p-5 sm:p-6 shadow-sm">
                            <div class="mb-5">
                                <h3 class="text-base font-bold text-dark flex items-center gap-2">
                                    <i class="fa-solid fa-lock text-primary"></i> Ganti Password
                                </h3>
                                <p class="text-xs text-netral-400 mt-1">Gunakan kombinasi huruf dan angka agar akun tetap
                                    aman.</p>
                            </div>

                            <div class="space-y-5 max-w-lg">
                                {{-- Password Saat Ini --}}
                                <div class="space-y-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-lock text-netral-400 text-xs"></i> Password Saat Ini
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="current_password" id="current_password"
                                            placeholder="Masukkan password saat ini"
                                            class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('current_password') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                        <button type="button" onclick="togglePassword('current_password', this)"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Password Baru --}}
                                <div class="space-y-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-key text-netral-400 text-xs"></i> Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password" id="password"
                                            placeholder="Minimal 8 karakter"
                                            class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('password') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                        <button type="button" onclick="togglePassword('password', this)"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @else
                                        <p class="text-xs text-netral-400">Password minimal 8 karakter, mengandung huruf dan
                                            angka</p>
                                    @enderror
                                </div>

                                {{-- Konfirmasi Password Baru --}}
                                <div class="space-y-2">
                                    <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                        <i class="fa-solid fa-check-double text-netral-400 text-xs"></i> Konfirmasi Password
                                        Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            placeholder="Ulangi password baru"
                                            class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('password_confirmation') border-danger focus:border-danger focus:ring-danger/20 @enderror">
                                        <button type="button" onclick="togglePassword('password_confirmation', this)"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    @error('password_confirmation')
                                        <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                            <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- ---------- Tombol Perbarui Password (sticky di mobile) ---------- --}}
                        <div class="sticky bottom-0 z-30 md:static">
                            <div
                                class="flex justify-end rounded-2xl md:rounded-none p-3 md:p-0 border border-netral-100 md:border-0 bg-white/95 backdrop-blur-sm md:bg-transparent md:backdrop-blur-none shadow-lg md:shadow-none md:pt-6 md:border-t md:border-netral-100">
                                <button type="submit"
                                    class="w-full sm:w-auto bg-dark text-white px-8 py-3 rounded-xl font-bold hover:bg-dark-hover hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-rotate"></i> Perbarui Password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @if (!$emailVerified)
        {{-- ===================== MODAL VERIFIKASI EMAIL (OTP) ===================== --}}
        <div id="otpModal" class="fixed inset-0 z-[1100] hidden" role="dialog" aria-modal="true"
            aria-labelledby="otpModalTitle">
            <div class="absolute inset-0 bg-dark/60 backdrop-blur-sm" onclick="closeOtpModal()"></div>

            <div class="relative h-full flex items-center justify-center p-4">
                <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden animate-fade-in">
                    {{-- Header --}}
                    <div class="bg-primary px-5 py-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center">
                                <i class="fa-solid fa-envelope-circle-check text-white"></i>
                            </div>
                            <div>
                                <h3 id="otpModalTitle" class="text-white font-bold text-sm">Verifikasi Email</h3>
                                <p class="text-white/70 text-xs">Masukkan 6 digit kode OTP</p>
                            </div>
                        </div>
                        <button type="button" onclick="closeOtpModal()" aria-label="Tutup"
                            class="text-white/80 hover:text-white transition-colors p-1">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>

                    {{-- Form verifikasi --}}
                    <form id="otpForm" action="{{ route('settings.email.verify') }}" method="POST" class="p-5">
                        @csrf
                        <input type="hidden" name="otp" id="otpValue">

                        <p class="text-xs text-netral-500 leading-relaxed mb-4">
                            Kode 6 digit telah dikirim ke
                            <span class="font-semibold text-dark">{{ $user->email }}</span>.
                            Kode berlaku <span class="font-semibold">{{ $otpTtlMinutes ?? 10 }} menit</span>.
                        </p>

                        <div class="flex justify-center gap-2 sm:gap-3 mb-4" id="otpInputs">
                            @for ($i = 0; $i < 6; $i++)
                                <input type="text" inputmode="numeric" autocomplete="one-time-code" maxlength="1"
                                    data-otp-input
                                    class="otp-input w-11 h-12 sm:w-12 sm:h-14 text-center text-xl font-bold border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-netral-50 outline-none transition-all">
                            @endfor
                        </div>

                        @error('otp')
                            <p class="text-danger text-xs mb-3 flex items-center justify-center gap-1">
                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                            </p>
                        @enderror

                        <button type="submit"
                            class="w-full bg-primary text-white py-3 rounded-xl font-bold hover:bg-primary-dark hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Verifikasi Sekarang
                        </button>
                    </form>

                    {{-- Kirim ulang --}}
                    <div class="px-5 pb-5 text-center border-t border-netral-100 pt-4">
                        <form action="{{ route('settings.email.send-otp') }}" method="POST">
                            @csrf
                            <button type="submit" id="otpResendBtn"
                                data-cooldown="{{ $otpCooldownLeft ?? 0 }}"
                                class="text-sm text-primary font-semibold hover:underline disabled:text-netral-400 disabled:no-underline disabled:cursor-not-allowed transition-colors">
                                Tidak menerima kode? Kirim ulang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @push('script')
        <script>
            // ==========================================
            // TAB SWITCHING (sidebar navigation)
            // ==========================================
            function switchTab(tabName) {
                document.querySelectorAll('.settings-content').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('tab-active'));

                const content = document.getElementById('tab-' + tabName);
                if (content) content.classList.remove('hidden');

                const btn = document.getElementById('btn-' + tabName);
                if (btn) btn.classList.add('tab-active');

                localStorage.setItem('activeSettingsTab', tabName);
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Bila ada error validasi password, langsung tampilkan tab Keamanan.
                const passwordError = document.querySelector('#tab-security .text-danger');
                const savedTab = localStorage.getItem('activeSettingsTab');
                switchTab(passwordError ? 'security' : (savedTab || 'profile'));
            });

            // ==========================================
            // PASSWORD TOGGLE VISIBILITY
            // ==========================================
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
                if (!input) return;
                const icon = btn.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            }
        </script>
    @endpush

    @push('script')
        <script>
            // ==========================================
            // AVATAR PREVIEW / REMOVE
            // ==========================================
            (function() {
                const input = document.getElementById('avatarInput');
                const removeBtn = document.getElementById('removeAvatarBtn');
                const removeField = document.getElementById('remove_avatar');
                const placeholderClasses =
                    'w-24 h-24 rounded-full bg-gradient-to-br from-netral-100 to-netral-200 flex items-center justify-center text-netral-400 border-4 border-white shadow-lg ring-1 ring-netral-100';
                const imageClasses =
                    'w-24 h-24 rounded-full object-cover border-4 border-white shadow-lg ring-1 ring-netral-100';

                if (input) {
                    input.addEventListener('change', function(e) {
                        const file = e.target.files && e.target.files[0];
                        if (!file) return;

                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            input.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            const preview = document.getElementById('avatarPreview');
                            if (!preview) return;

                            if (preview.tagName.toLowerCase() === 'div') {
                                const img = document.createElement('img');
                                img.id = 'avatarPreview';
                                img.className = imageClasses;
                                img.src = ev.target.result;
                                img.alt = 'avatar';
                                preview.parentNode.replaceChild(img, preview);
                            } else {
                                preview.src = ev.target.result;
                            }
                            if (removeField) removeField.value = '0';
                        };
                        reader.readAsDataURL(file);
                    });
                }

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        if (input) input.value = '';

                        const preview = document.getElementById('avatarPreview');
                        if (preview) {
                            const div = document.createElement('div');
                            div.id = 'avatarPreview';
                            div.className = placeholderClasses;
                            div.innerHTML = '<i class="fa-solid fa-user text-3xl"></i>';
                            preview.parentNode.replaceChild(div, preview);
                        }

                        if (removeField) removeField.value = '1';
                    });
                }
            })();
        </script>
    @endpush

    @push('script')
        <script>
            // ==========================================
            // MODAL VERIFIKASI EMAIL (OTP)
            // ==========================================
            function openOtpModal() {
                const modal = document.getElementById('otpModal');
                if (!modal) return;

                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';

                const inputs = modal.querySelectorAll('[data-otp-input]');
                if (inputs.length) inputs[0].focus();
            }

            function closeOtpModal() {
                const modal = document.getElementById('otpModal');
                if (!modal) return;

                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }

            (function initOtpModal() {
                const modal = document.getElementById('otpModal');
                if (!modal) return;

                const inputs = Array.from(modal.querySelectorAll('[data-otp-input]'));
                const hidden = document.getElementById('otpValue');
                const form = document.getElementById('otpForm');

                const sync = () => {
                    if (hidden) hidden.value = inputs.map(i => i.value).join('');
                };

                inputs.forEach((input, idx) => {
                    input.addEventListener('input', () => {
                        input.value = input.value.replace(/\D/g, '').slice(-1);
                        if (input.value && idx < inputs.length - 1) inputs[idx + 1].focus();
                        sync();
                    });

                    input.addEventListener('keydown', (e) => {
                        if (e.key === 'Backspace' && !input.value && idx > 0) {
                            inputs[idx - 1].value = '';
                            inputs[idx - 1].focus();
                            sync();
                        } else if (e.key === 'ArrowLeft' && idx > 0) {
                            inputs[idx - 1].focus();
                        } else if (e.key === 'ArrowRight' && idx < inputs.length - 1) {
                            inputs[idx + 1].focus();
                        }
                    });

                    input.addEventListener('paste', (e) => {
                        const text = (e.clipboardData || window.clipboardData)
                            .getData('text').replace(/\D/g, '');
                        if (!text) return;
                        e.preventDefault();
                        inputs.forEach((el, i) => { el.value = text[i] || ''; });
                        sync();
                        const last = Math.min(text.length, inputs.length) - 1;
                        if (last >= 0) inputs[last].focus();
                    });
                });

                if (form) {
                    form.addEventListener('submit', (e) => {
                        sync();
                        if (!hidden || hidden.value.length !== 6) {
                            e.preventDefault();
                            alert('Masukkan 6 digit kode OTP terlebih dahulu.');
                        }
                    });
                }

                // Hitungan mundur tombol "kirim ulang" (cooldown dari server)
                const resend = document.getElementById('otpResendBtn');
                if (resend) {
                    const label = resend.textContent.trim();
                    let left = parseInt(resend.dataset.cooldown || '0', 10);

                    if (left > 0) {
                        resend.disabled = true;
                        const tick = () => {
                            if (left <= 0) {
                                resend.disabled = false;
                                resend.textContent = label;
                                return;
                            }
                            resend.textContent = 'Kirim ulang dalam ' + left + 's';
                            left--;
                            window.setTimeout(tick, 1000);
                        };
                        tick();
                    }
                }

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeOtpModal();
                });

                @if (session('otp_sent') || $errors->has('otp'))
                    openOtpModal();
                @endif
            })();
        </script>
    @endpush

    @push('style')
        <style>
            .animate-fade-in {
                animation: fadeIn 0.3s ease-out;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            /* Indikator tab aktif: highlight pastel + garis batas kiri (desktop)
               atau garis bawah (mobile). */
            .tab-btn {
                transition: background-color .2s ease, color .2s ease, box-shadow .2s ease;
            }

            .tab-btn.tab-active {
                background-color: oklch(97% 0.014 254.604);
                /* primary-light */
                color: oklch(48.8% 0.243 264.376);
                /* primary-dark */
                font-weight: 700;
                box-shadow: inset 3px 0 0 0 oklch(54.6% 0.245 262.881);
                /* primary */
            }

            @media (max-width: 1023.98px) {
                .tab-btn.tab-active {
                    box-shadow: inset 0 -3px 0 0 oklch(54.6% 0.245 262.881);
                }
            }

            /* Sembunyikan scrollbar pada tab horizontal (mobile) */
            .no-scrollbar {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            .no-scrollbar::-webkit-scrollbar {
                display: none;
            }
        </style>
    @endpush
@endsection
