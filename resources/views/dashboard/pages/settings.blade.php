@extends('dashboard.layouts.index')

@section('title', 'Pengaturan Akun | InfoHilang')
@section('content')
    <div class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-8 p-1">
            <div class="text-center lg:text-left order-2 lg:order-1 pointer-events-auto">
                <h1 class="text-3xl font-bold text-dark">Pengaturan Akun</h1>
                <p class="text-xs font-medium text-netral-400 mt-2">Kelola informasi profil dan keamanan akun Anda.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-success text-white rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">
            {{-- Sidebar Tabs --}}
            <div class="w-full md:w-1/4 space-y-2">
                <button onclick="switchTab('profile')" id="btn-profile"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-user"></i> Profil Umum
                </button>
                <button onclick="switchTab('security')" id="btn-security"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-netral-100 text-netral-600 hover:bg-netral-200 hover:text-dark font-medium transition-all duration-300">
                    <i class="fa-solid fa-shield-halved"></i> Keamanan
                </button>
            </div>

            {{-- Content Area --}}
            <div class="flex-1 bg-white border border-netral-100 rounded-3xl p-6 md:p-8 shadow-sm min-h-[500px]">

                {{-- Tab Profile --}}
                <div id="tab-profile" class="settings-content animate-fade-in">
                    <h3 class="text-xl text-dark font-bold mb-6">Informasi Profil</h3>
                    <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            {{-- Avatar Column --}}
                            <div class="col-span-1 bg-netral-50 p-6 rounded-2xl flex flex-col items-center">
                                <div id="avatarPreviewWrap" class="mb-4 relative group">
                                    @if (!empty($user->avatar))
                                        <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                            class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg">
                                    @else
                                        <div id="avatarPreview"
                                            class="w-32 h-32 rounded-full bg-gradient-to-br from-netral-100 to-netral-200 flex items-center justify-center text-netral-400 border-4 border-white shadow-lg">
                                            <i class="fa-solid fa-user text-4xl"></i>
                                        </div>
                                    @endif
                                    
                                    {{-- Hover overlay untuk upload --}}
                                    <div class="absolute inset-0 rounded-full bg-dark/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center cursor-pointer"
                                         onclick="document.getElementById('avatarInput').click()">
                                        <i class="fa-solid fa-camera text-white text-xl"></i>
                                    </div>
                                </div>

                                <input id="avatarInput" type="file" name="avatar" accept="image/*" class="hidden">
                                <input type="hidden" id="remove_avatar" name="remove_avatar" value="0">
                                
                                <button type="button" onclick="document.getElementById('avatarInput').click()"
                                    class="mb-2 px-4 py-2 bg-white border border-netral-200 rounded-lg text-sm font-medium text-dark hover:border-primary hover:text-primary transition-colors shadow-sm">
                                    <i class="fa-solid fa-upload mr-2"></i>Ganti Foto
                                </button>

                                @if (!empty($user->avatar))
                                    <button type="button" id="removeAvatarBtn"
                                        class="text-sm text-danger hover:text-danger-dark font-medium transition-colors">
                                        <i class="fa-solid fa-trash mr-1"></i>Hapus Foto
                                    </button>
                                @endif
                                
                                <p class="text-xs text-netral-400 mt-4 text-center leading-relaxed">
                                    Format: JPG, JPEG, PNG<br>Maksimal 2MB
                                </p>
                            </div>

                            {{-- Fields Column --}}
                            <div class="col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    {{-- Nama Lengkap --}}
                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-id-card text-netral-400 text-xs"></i> Nama Lengkap
                                        </label>
                                        <input type="text" name="fullname"
                                            value="{{ old('fullname', $user->fullname ?? ($user->name ?? '')) }}"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('fullname') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                                            placeholder="Masukkan nama lengkap">
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
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('username') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                                            placeholder="username_anda">
                                        @error('username')
                                            <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-envelope text-netral-400 text-xs"></i> Alamat Email
                                        </label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none @error('email') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                                            placeholder="email@contoh.com">
                                        @error('email')
                                            <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Phone --}}
                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                            <i class="fa-solid fa-phone text-netral-400 text-xs"></i> Nomor WhatsApp
                                        </label>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
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
                                        <textarea name="alamat" rows="3"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none resize-none @error('alamat') border-danger focus:border-danger focus:ring-danger/20 @enderror"
                                            placeholder="Masukkan alamat lengkap Anda">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                        @error('alamat')
                                            <p class="text-danger text-xs mt-1 flex items-center gap-1">
                                                <i class="fa-solid fa-circle-exclamation text-[10px]"></i>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Kontak Tambahan --}}
                                    <div class="md:col-span-2 mt-2">
                                        @include('dashboard.components.contacts', [
                                            'kontak' => old('kontak', $kontak ?? []),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-8 pt-6 border-t border-netral-100 flex justify-end">
                            <button type="submit"
                                class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center gap-2">
                                <i class="fa-solid fa-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Tab Security --}}
                <div id="tab-security" class="settings-content hidden animate-fade-in">
                    <h3 class="text-xl text-dark font-bold mb-2">Ganti Password</h3>
                    <p class="text-sm text-netral-500 mb-8">Pastikan password Anda kuat dan mudah diingat.</p>
                    
                    <form action="{{ route('settings.password.update') }}" method="POST" class="max-w-lg">
                        @csrf @method('PUT')
                        
                        <div class="space-y-5">
                            {{-- Current Password --}}
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                    <i class="fa-solid fa-lock text-netral-400 text-xs"></i> Password Saat Ini
                                </label>
                                <div class="relative">
                                    <input type="password" name="current_password" id="current_password"
                                        class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none"
                                        placeholder="Masukkan password saat ini">
                                    <button type="button" onclick="togglePassword('current_password', this)" 
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            {{-- New Password --}}
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                    <i class="fa-solid fa-key text-netral-400 text-xs"></i> Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password"
                                        class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none"
                                        placeholder="Minimal 8 karakter">
                                    <button type="button" onclick="togglePassword('password', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                                <p class="text-xs text-netral-400">Password minimal 8 karakter, mengandung huruf dan angka</p>
                            </div>

                            {{-- Confirm Password --}}
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold flex items-center gap-2">
                                    <i class="fa-solid fa-check-double text-netral-400 text-xs"></i> Konfirmasi Password Baru
                                </label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation"
                                        class="w-full px-4 py-3 pr-12 border border-netral-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 bg-white text-sm transition-all outline-none"
                                        placeholder="Ulangi password baru">
                                    <button type="button" onclick="togglePassword('password_confirmation', this)"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-netral-400 hover:text-netral-600 transition-colors p-1">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Submit Button --}}
                        <div class="mt-8 pt-6 border-t border-netral-100">
                            <button type="submit"
                                class="bg-dark text-white px-8 py-3 rounded-xl font-bold hover:bg-dark-hover hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0 transition-all duration-300 flex items-center gap-2">
                                <i class="fa-solid fa-rotate"></i> Perbarui Password
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('script')
        <script>
            // ==========================================
            // TAB SWITCHING - DIperbaiki
            // ==========================================
            function switchTab(tabName) {
                // 1. Sembunyikan semua content
                document.querySelectorAll('.settings-content').forEach(el => {
                    el.classList.add('hidden');
                });

                // 2. Reset semua button style
                document.querySelectorAll('.tab-btn').forEach(btn => {
                    // Reset ke style default (non-active)
                    btn.classList.remove('bg-primary', 'text-white', 'font-bold', 'shadow-sm');
                    btn.classList.add('bg-netral-100', 'text-netral-600', 'font-medium', 'hover:bg-netral-200', 'hover:text-dark');
                });

                // 3. Tampilkan content yang dipilih
                const selectedContent = document.getElementById('tab-' + tabName);
                if (selectedContent) {
                    selectedContent.classList.remove('hidden');
                }

                // 4. Style button yang aktif
                const activeBtn = document.getElementById('btn-' + tabName);
                if (activeBtn) {
                    activeBtn.classList.remove('bg-netral-100', 'text-netral-600', 'font-medium', 'hover:bg-netral-200', 'hover:text-dark');
                    activeBtn.classList.add('bg-primary', 'text-white', 'font-bold', 'shadow-sm');
                }

                // 5. Save to localStorage untuk remember tab
                localStorage.setItem('activeSettingsTab', tabName);
            }

            // Restore tab dari localStorage saat page load
            document.addEventListener('DOMContentLoaded', function() {
                const savedTab = localStorage.getItem('activeSettingsTab');
                if (savedTab && document.getElementById('tab-' + savedTab)) {
                    switchTab(savedTab);
                }
            });

            // ==========================================
            // AVATAR HANDLING - Diperbaiki
            // ==========================================
            (function() {
                const input = document.getElementById('avatarInput');
                const preview = document.getElementById('avatarPreview');
                const removeBtn = document.getElementById('removeAvatarBtn');
                const removeField = document.getElementById('remove_avatar');

                if (input) {
                    input.addEventListener('change', function(e) {
                        const file = e.target.files && e.target.files[0];
                        if (!file) return;
                        
                        // Validasi ukuran (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            alert('Ukuran file terlalu besar. Maksimal 2MB.');
                            input.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            if (preview) {
                                // Jika sebelumnya div, ganti jadi img
                                if (preview.tagName.toLowerCase() === 'div') {
                                    const img = document.createElement('img');
                                    img.id = 'avatarPreview';
                                    img.className = 'w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg';
                                    img.src = ev.target.result;
                                    img.alt = 'avatar';
                                    preview.parentNode.replaceChild(img, preview);
                                } else {
                                    preview.src = ev.target.result;
                                }
                            }
                            if (removeField) removeField.value = '0';
                        };
                        reader.readAsDataURL(file);
                    });
                }

                if (removeBtn) {
                    removeBtn.addEventListener('click', function() {
                        if (input) input.value = '';
                        
                        if (preview) {
                            // Ganti jadi div placeholder
                            const div = document.createElement('div');
                            div.id = 'avatarPreview';
                            div.className = 'w-32 h-32 rounded-full bg-gradient-to-br from-netral-100 to-netral-200 flex items-center justify-center text-netral-400 border-4 border-white shadow-lg';
                            div.innerHTML = '<i class="fa-solid fa-user text-4xl"></i>';
                            preview.parentNode.replaceChild(div, preview);
                        }
                        
                        if (removeField) removeField.value = '1';
                    });
                }
            })();

            // ==========================================
            // PASSWORD TOGGLE VISIBILITY
            // ==========================================
            function togglePassword(inputId, btn) {
                const input = document.getElementById(inputId);
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
        </style>
    @endpush
@endsection