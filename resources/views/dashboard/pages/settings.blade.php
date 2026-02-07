@extends('dashboard.layouts.index')

@section('content')
<div class="space-y-6">
    <header class="mb-8">
        <h1 class="text-2xl font-bold text-dark mb-2">Pengaturan Akun</h1>
        <p class="text-netral-500">Kelola informasi profil dan keamanan akun Anda.</p>
    </header>

    @if(session('success'))
        <div class="mb-6 p-4 bg-success text-white rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row gap-8">
        <div class="w-full md:w-1/4 space-y-2">
            <button onclick="switchTab('profile')" id="btn-profile" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-white font-bold transition">
                <i class="fa-solid fa-user"></i> Profil Umum
            </button>
            <button onclick="switchTab('security')" id="btn-security" class="tab-btn w-full flex items-center gap-3 px-4 py-3 rounded-xl bg-netral-100 hover:bg-primary-light text-dark transition">
                <i class="fa-solid fa-shield-halved"></i> Keamanan
            </button>
        </div>

        <div class="flex-1 bg-white border border-netral-100 rounded-3xl p-6 md:p-8 shadow-sm">

            <div id="tab-profile" class="settings-content">
                <h3 class="text-xl text-dark font-bold mb-6">Informasi Profil</h3>
                <form action="{{ route('settings.profile.update') }}" method="POST">
                    @csrf @method('PUT')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-sm text-dark font-semibold">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ $user->name }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm text-dark font-semibold">Alamat Email</label>
                            <input type="email" name="email" value="{{ $user->email }}" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                        <div class="space-y-2 md:col-span-2">
                            <label class="text-sm text-dark font-semibold">Nomor WhatsApp</label>
                            <input type="text" name="phone" value="{{ $user->phone ?? '' }}" placeholder="0812..." class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                    </div>
                    <button type="submit" class="mt-8 bg-primary text-white px-8 py-3 rounded-xl font-bold hover:bg-primary-dark hover:shadow-lg transition">Simpan Perubahan</button>
                </form>
            </div>

            <div id="tab-security" class="settings-content hidden">
                <h3 class="text-xl text-dark font-bold mb-6">Ganti Password</h3>
                <form action="{{ route('settings.password.update') }}" method="POST" class="max-w-md">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm text-dark font-semibold">Password Saat Ini</label>
                            <input type="password" name="current_password" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm text-dark font-semibold">Password Baru</label>
                            <input type="password" name="password" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="text-sm text-dark font-semibold">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                        </div>
                    </div>
                    <button type="submit" class="mt-8 bg-dark text-white px-8 py-3 rounded-xl font-bold hover:bg-dark-hover transition">Perbarui Password</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    function switchTab(tab) {
        document.querySelectorAll('.settings-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.tab-btn').forEach(el => {
            el.classList.remove('bg-primary', 'text-white', 'font-bold');
            el.classList.add('hover:bg-primary-light', 'text-dark', 'bg-netral-100');
        });

        document.getElementById('tab-' + tab).classList.remove('hidden');
        const activeBtn = document.getElementById('btn-' + tab);
        activeBtn.classList.add('bg-primary', 'text-white', 'font-bold');
        activeBtn.classList.remove('hover:bg-primary-light', 'text-dark');
    }
</script>
@endsection
