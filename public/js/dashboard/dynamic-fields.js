/**
 * dynamic-fields.js
 * Handle tambah/hapus field dinamis untuk Form Laporan (InfoHilang)
 * characteristics.blade.php
 * contacts.blade.php
*/

// function removeField(button) {
//     const field = button.closest(".grid");
//     if (field) field.remove();
// }

function removeField(button) {
    // Cari baris terdeket yang punya class 'grid'
    const row = button.closest('.grid');

    // Cek container mana yang lagi diproses (Kontak atau Ciri-ciri)
    const container = row.parentElement;

    // Jangan hapus kalau itu satu-satunya row yang tersisa
    if (container.querySelectorAll('.grid').length > 1) {
        row.remove();
    } else {
        // Kalau tinggal satu, cukup kosongkan isinya aja
        row.querySelectorAll('input').forEach(input => input.value = '');
    }
}

function addCiriCiriField() {
    const container = document.getElementById("ciriCiriContainer");
    const div = document.createElement("div");
    div.className = "grid grid-cols-1 sm:grid-cols-2 gap-2";
    div.innerHTML = `
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                class="px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
            <div class="relative">
                <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                    class="w-full px-4 py-3 pl-3 pr-8 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger"
                    onclick="removeField(this.closest('.grid'))">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>`;
    container.appendChild(div);
}

function addKontakField() {
    const container = document.getElementById("kontakContainer");
    const div = document.createElement("div");
    div.className = "grid grid-cols-1 sm:grid-cols-2 gap-2";
    div.innerHTML = `
            <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                class="px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
            <div class="relative">
                <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                    class="w-full px-4 py-3 border border-netral-200 rounded-xl focus:border-primary bg-netral-50 text-sm transition-all outline-none">
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger"
                    onclick="removeField(this.closest('.grid'))">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>`;
    container.appendChild(div);
}
