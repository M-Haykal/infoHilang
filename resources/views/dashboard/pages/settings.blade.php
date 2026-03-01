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

            {{-- <div class="order-1 lg:order-2 flex justify-center lg:justify-end relative z-20 pointer-events-auto">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-dark border border-netral-200 rounded-xl font-bold text-sm shadow-sm hover:text-primary hover:border-primary hover:shadow-md transition-all group active:scale-95">
                    <i class="fa-solid fa-arrow-left transition-transform group-hover:-translate-x-1"></i>
                    <span>Kembali</span>
                </a>
            </div> --}}
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-success text-white rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-1/4 space-y-2">
                <button onclick="switchTab('profile')" id="btn-profile"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition">
                    <i class="fa-solid fa-user"></i> Profil Umum
                </button>
                <button onclick="switchTab('security')" id="btn-security"
                    class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-netral-100 hover:bg-primary-light text-dark transition">
                    <i class="fa-solid fa-shield-halved"></i> Keamanan
                </button>
            </div>

            <div class="flex-1 bg-white border border-netral-100 rounded-3xl p-6 md:p-8 shadow-sm">

                <div id="tab-profile" class="settings-content">
                    <h3 class="text-xl text-dark font-bold mb-6">Informasi Profil</h3>
                    <form action="{{ route('settings.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Avatar column -->
                            <div class="col-span-1 bg-netral-50 p-4 rounded-xl flex flex-col items-center">
                                <div id="avatarPreviewWrap" class="mb-4">
                                    @if (!empty($user->avatar))
                                        <img id="avatarPreview" src="{{ asset('storage/' . $user->avatar) }}" alt="avatar"
                                            class="w-28 h-28 rounded-full object-cover border">
                                    @else
                                        <div id="avatarPreview"
                                            class="w-28 h-28 rounded-full bg-netral-100 flex items-center justify-center text-netral-400 border">
                                            No Image</div>
                                    @endif
                                </div>
                                <input id="avatarInput" type="file" name="avatar" accept="image/*" class="mb-2">
                                <input type="hidden" id="remove_avatar" name="remove_avatar" value="0">
                                @if (!empty($user->avatar))
                                    <div class="flex gap-2">
                                        <button type="button" id="removeAvatarBtn"
                                            class="text-sm text-danger hover:underline">Hapus</button>
                                    </div>
                                @endif
                                <p class="text-xs text-netral-400 mt-3 text-center">Upload avatar (jpg, jpeg, png). Maks
                                    2MB.</p>
                            </div>

                            <!-- Fields column -->
                            <div class="col-span-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold">Nama Lengkap</label>
                                        <input type="text" name="fullname"
                                            value="{{ old('fullname', $user->fullname ?? ($user->name ?? '')) }}"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('fullname') border-danger @enderror">
                                        @error('fullname')
                                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold">Username</label>
                                        <input type="text" name="username"
                                            value="{{ old('username', $user->username ?? '') }}"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('username') border-danger @enderror">
                                        @error('username')
                                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold">Alamat Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('email') border-danger @enderror">
                                        @error('email')
                                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2">
                                        <label class="text-sm text-dark font-semibold">Nomor WhatsApp</label>
                                        <input type="text" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                                            placeholder="0812..."
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('phone') border-danger @enderror">
                                        @error('phone')
                                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="space-y-2 md:col-span-2">
                                        <label class="text-sm text-dark font-semibold">Alamat</label>
                                        <textarea name="alamat" rows="2"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none @error('alamat') border-danger @enderror">{{ old('alamat', $user->alamat ?? '') }}</textarea>
                                        @error('alamat')
                                            <p class="text-danger text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="md:col-span-2 mt-4">
                                        @include('dashboard.components.contacts', [
                                            'kontak' => old('kontak', $kontak ?? []),
                                        ])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit"
                                class="bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark hover:shadow-lg transition">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>

                <div id="tab-security" class="settings-content hidden">
                    <h3 class="text-xl text-dark font-bold mb-6">Ganti Password</h3>
                    <form action="{{ route('settings.password.update') }}" method="POST" class="max-w-md">
                        @csrf @method('PUT')
                        <div class="space-y-4">
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold">Password Baru</label>
                                <input type="password" name="password"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm text-dark font-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                            </div>
                        </div>
                        <button type="submit"
                            class="mt-8 bg-dark text-white px-8 py-3 rounded-xl font-bold hover:bg-dark-hover transition">Perbarui
                            Password</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    @push('script')
        <script>
            function switchTab(tab) {
                document.querySelectorAll('.settings-content').forEach(el => el.classList.add('hidden'));
                document.querySelectorAll('.tab-btn').forEach(el => {
                    el.classList.remove('bg-primary', 'text-white', 'font-bold');
                    el.classList.add('hover:bg-primary-light', 'text-dark', 'bg-netral-100');
                });
            }
            // Avatar preview and remove handling
            (function() {
                const input = document.getElementById('avatarInput');
                const preview = document.getElementById('avatarPreview');
                const removeBtn = document.getElementById('removeAvatarBtn');
                const removeField = document.getElementById('remove_avatar');

                function setPreviewSrc(src) {
                    if (!preview) return;
                    if (preview.tagName.toLowerCase() === 'img') {
                        preview.src = src;
                    } else {
                        preview.textContent = '';
                        preview.style.backgroundImage = `url('${src}')`;
                    }
                }

                if (input) {
                    input.addEventListener('change', function(e) {
                        const file = e.target.files && e.target.files[0];
                        if (!file) return;
                        const reader = new FileReader();
                        reader.onload = function(ev) {
                            if (preview && preview.tagName.toLowerCase() === 'img') {
                                preview.src = ev.target.result;
                            } else if (preview) {
                                preview.style.backgroundImage = `url('${ev.target.result}')`;
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
                            if (preview.tagName.toLowerCase() === 'img') {
                                preview.src = '';
                                preview.alt = 'No Image';
                                preview.style.display = 'block';
                            } else {
                                preview.style.backgroundImage = '';
                                preview.textContent = 'No Image';
                            }
                        }
                        if (removeField) removeField.value = '1';
                    });
                }
            })();
        </script>
    @endpush
@endsection
