<!-- user-contact-selector.blade.php -->
<div id="user-contact-modal" onclick="if(event.target.id==='user-contact-modal') closeUserContactModal();"
    class="fixed inset-0 z-[9998] hidden items-center justify-center backdrop-blur-sm p-4">
    <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[80vh] overflow-hidden flex flex-col">
        <!-- header -->
        <div class="p-6 border-b border-netral-200 flex justify-between items-center">
            <h2 class="text-xl font-bold text-dark">Pilih Kontak dari Pengguna</h2>
            <button type="button" onclick="closeUserContactModal()" class="text-netral-400 hover:text-danger text-2xl">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <!-- search -->
        <div class="p-4 border-b border-netral-200">
            <input type="text" id="user-contact-search" placeholder="Cari nama atau email pengguna..."
                class="w-full px-4 py-3 border border-netral-200 rounded-lg focus:border-primary focus:ring-1 focus:ring-primary outline-none text-sm" />
        </div>

        <!-- list -->
        <div id="user-contact-list" class="overflow-y-auto flex-1 p-2">
            <div class="p-8 text-center text-netral-400">
                <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>
                <p>Mulai mengetik untuk mencari pengguna</p>
            </div>
        </div>
        <p class="text-xs text-netral-500 mt-2">Klik baris pengguna untuk menyalin seluruh kontaknya ke formulir.</p>
    </div>
</div>
