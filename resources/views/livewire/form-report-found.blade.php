<div wire:key="form-report-found-root" x-data="{ showReportModal: @entangle('showReportModal').live }">
    <div x-show="showReportModal"
        class="fixed inset-0 z-[9999] flex items-center justify-center backdrop-blur-md p-4 sm:p-6" x-cloak>
        <div x-show="showReportModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" class="absolute inset-0 backdrop-blur-md"></div>

        <div x-show="showReportModal" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" @click.away="showReportModal = false"
            class="relative bg-white w-full max-w-4xl max-h-[calc(100dvh-40px)] shadow-2xl flex flex-col border border-netral-100 rounded-xl overflow-hidden">

            <div class="p-6 border-b border-netral-50 flex justify-between items-center bg-white sticky top-0 z-10">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-light rounded-2xl flex items-center justify-center text-primary">
                        <i class="fa-solid fa-bullhorn text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl md:text-2xl font-bold text-dark">Kontribusi Informasi Temuan</h2>
                        <p class="text-xs font-medium text-netral-400">Bantu perkuat jejak pencarian</p>
                    </div>
                </div>
                <button @click="showReportModal = false"
                    class="w-12 h-12 rounded-full hover:bg-netral-100 flex items-center justify-center text-netral-400 transition-all">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <div class="p-6 overflow-y-auto no-scrollbar flex-1 bg-netral-50">
                <form wire:submit.prevent="create" class="grid grid-cols-1 md:grid-cols-2 gap-5 items-stretch"
                    x-data="{
                        images: [],
                        handleFiles(event) {
                            const files = Array.from(event.target.files);
                            if (this.images.length + files.length > 3) {
                                alert('Maksimal hanya 3 gambar yang diperbolehkan.');
                                return;
                            }
                            files.forEach(file => {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    this.images.push(e.target.result);
                                };
                                reader.readAsDataURL(file);
                            });
                        },
                        removeImage(index) {
                            this.images.splice(index, 1);
                        }
                    }">
                    <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- Jika user login --}}
                        @auth
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">Nama Penemu</label>
                                <input type="text" wire:model="nama_penemu"
                                    @if ($laporAnonim) readonly @endif
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl text-sm
                                    {{ $laporAnonim ? 'bg-netral-100 cursor-not-allowed' : 'bg-white' }}">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-dark mb-2">Kontak Penemu</label>
                                <input type="text" wire:model="kontak_penemu"
                                    class="w-full px-4 py-3 border rounded-xl text-sm">
                            </div>
                        @endauth

                        {{-- Jika belum login / anonim --}}
                        @guest
                            <div class="md:col-span-2">
                                <div class="flex items-center gap-3 mb-3">
                                    <input type="checkbox" wire:model.live="isiKontak" id="isiKontak"
                                        class="rounded border-netral-300">
                                    <label for="isiKontak" class="text-xs font-bold text-netral-500">
                                        Saya ingin mencantumkan kontak saya
                                    </label>
                                </div>

                                @if ($isiKontak)
                                    <div>
                                        <label class="block text-xs font-bold text-dark mb-2">Kontak Penemu</label>
                                        <input type="text" wire:model="kontak_penemu" placeholder="Contoh: 08123456789"
                                            class="w-full px-4 py-3 border border-netral-200 rounded-xl bg-white text-sm">
                                    </div>
                                @endif
                            </div>
                        @endguest
                    </div>

                    <div class="md:col-span-2 bg-white border border-netral-100 rounded-xl p-4">
                        @guest
                            <p class="text-xs text-netral-500 font-medium">
                                Kamu saat ini melapor sebagai <span class="font-bold text-dark">Anonim</span> karena belum
                                login.
                            </p>
                        @endguest
                        @auth
                            <div class="flex items-center gap-3">
                                <input type="checkbox" wire:model.live="laporAnonim" id="anonim"
                                    class="rounded border-netral-300">
                                <label for="anonim" class="text-xs font-bold text-netral-500">
                                    Laporkan sebagai anonim
                                </label>
                            </div>
                            <p class="text-[10px] text-netral-400 mt-1">
                                Jika diaktifkan, nama akun Anda tidak akan ditampilkan di laporan publik.
                            </p>
                        @endauth
                    </div>

                    <div class="flex flex-col h-full space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-dark mb-2">Informasi Lokasi <span
                                    class="text-danger">*</span></label>
                            <div class="relative group">
                                <input type="text" placeholder="Di mana kamu melihatnya? (Misal: Lobby Utama Mall X)"
                                    wire:model="lokasi_ditemukan" required name="lokasi_ditemukan"
                                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none">
                            </div>
                        </div>

                        <div class="flex-1 flex flex-col">
                            <label class="block text-xs font-bold text-dark mb-2">Detail Kronologi & Deskripsi</label>
                            <textarea rows="5"
                                placeholder="Jelaskan kondisi terakhir yang terlihat (pakaian, arah pergi, atau kondisi barang)..."
                                wire:model="keterangan" name="keterangan"
                                class="flex-1 w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-white text-sm transition-all outline-none"></textarea>
                        </div>
                    </div>

                    <div class="flex flex-col h-full space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-dark mb-2">Unggah Bukti Foto (Maks. 3) (Opsional)
                                <span class="text-netral-400 font-normal"
                                    x-text="`(${images.length}/3)`"></span></label>

                            <div class="flex items-center justify-center w-full">
                                <label
                                    class="flex flex-col items-center justify-center w-full h-20 border-2 border-dashed rounded-xl transition-all group"
                                    :class="images.length >= 3 ? 'bg-netral-100 border-netral-200 cursor-not-allowed' :
                                        'bg-white border-netral-200 cursor-pointer hover:border-primary'">
                                    <div class="flex items-center gap-3">
                                        <div class="rounded-2xl flex items-center justify-center transition-all shrink-0"
                                            :class="images.length < 3 ? 'group-hover:scale-110' : ''">
                                            <i class="fa-solid fa-cloud-arrow-up text-2xl transition-colors"
                                                :class="images.length >= 3 ? 'text-netral-300 group-hover:text-netral-300' :
                                                    'text-netral-400 group-hover:text-primary'"></i>
                                        </div>

                                        <div class="flex flex-col">
                                            <p class="text-xs font-bold tracking-tight transition-colors"
                                                :class="images.length >= 3 ? 'text-netral-400' : 'text-netral-500'">
                                                <span
                                                    x-text="images.length >= 3 ? 'Batas maksimal foto tercapai' : 'Klik untuk unggah atau seret foto'"></span>
                                            </p>
                                            <p class="text-[10px] mt-0.5 uppercase font-bold transition-colors"
                                                :class="images.length >= 3 ? 'text-netral-300' : 'text-netral-400'">PNG,
                                                JPG (Max. 5MB)</p>
                                        </div>
                                    </div>
                                    <input type="file" wire:model="bukti_ditemukan" name="bukti_ditemukan[]"
                                        class="hidden" accept="image/*" multiple @change="handleFiles($event)"
                                        :disabled="images.length >= 3">
                                </label>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-3" x-show="images.length > 0">
                                <template x-for="(img, index) in images" :key="index">
                                    <div
                                        class="relative w-14 h-14 rounded-lg overflow-hidden group border border-netral-100 shadow-sm shrink-0">
                                        <img :src="img" class="w-full h-full object-cover">
                                        <button @click.prevent="removeImage(index)"
                                            class="absolute inset-0 bg-danger-light text-white opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <i class="fa-solid fa-trash-can text-[10px]"></i>
                                        </button>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <div class="px-5 py-3 rounded-2xl border bg-white">
                            <div class="flex gap-3 items-start text-primary">
                                <i class="fa-solid fa-circle-info mt-1"></i>
                                <p class="text-[10px] font-bold leading-relaxed">Informasi yang kamu kirim akan muncul
                                    di timeline publik setelah divalidasi oleh pemilik atau admin.</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <button type="submit"
                            class="w-full py-3 bg-primary text-white rounded-xl font-bold shadow-xl hover:bg-primary-dark hover:scale-[1.01] active:scale-95 transition-all flex items-center justify-center gap-3">Kirim
                            Laporan Temuan <i class="fa-solid fa-paper-plane"></i></button>
                        <p class="text-center text-[10px] text-netral-400 mt-4 font-medium italic">*Dengan mengirim,
                            kamu setuju untuk memberikan informasi yang jujur dan bertanggung jawab.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
