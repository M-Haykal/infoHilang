import "./bootstrap";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
import introJs from "intro.js";
import "intro.js/introjs.css";
import "select2";
import "select2/dist/css/select2.min.css";
import "trix";
import "trix/dist/trix.css";

window.Pusher = Pusher;
window.introJs = introJs;

/**
 * Configure Echo for Reverb (WebSocket broadcasting).
 * Reverb is a self-hosted WebSocket server that is Pusher-compatible.
 * Uses the same Pusher JS client library with Reverb connection settings.
 */
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 8080,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
});

document.addEventListener("DOMContentLoaded", () => {
    const pageElement = document.querySelector(
        '[data-page="dashboard"], [data-page="form-animal-missing"], [data-page="form-person-missing"], [data-page="form-stuff-missing"], [data-page="admin-manage-report"], [data-page="admin-manage-user"], [data-page="admin-chat"], [data-page="admin-customer-chats"]',
    );
    if (!pageElement) return;

    const page = pageElement.dataset.page;

    // ============================================================
    //  DEFINISI TOUR UNTUK SEMUA HALAMAN
    // ============================================================
    const tours = {
        // ==================== USER TOURS ====================

        // -------------------- DASHBOARD USER --------------------
        dashboard: {
            key: "tour_dashboard_done",
            steps: [
                {
                    title: "Selamat Datang di Dashboard InfoHilang!",
                    intro: "Di sini Anda dapat melihat ringkasan laporan kehilangan dan menambahkan laporan baru.",
                },
                {
                    title: "Halaman Dashboard",
                    element: "#dashboard",
                    intro: "Ini adalah halaman dashboard utama Anda. Dengan berbagai menu dan informasi penting.",
                    position: "bottom",
                },
                {
                    title: "Memperluas Tampilan",
                    element: "#fullscreen-button",
                    intro: "Klik tombol ini untuk memperluas tampilan dashboard ke layar penuh.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Barang Hilang",
                    element: "#missing-stuff-card",
                    intro: "Jumlah laporan barang hilang yang telah dibuat.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Orang Hilang",
                    element: "#missing-person-card",
                    intro: "Jumlah laporan orang hilang yang telah dibuat.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Hewan Hilang",
                    element: "#missing-animal-card",
                    intro: "Jumlah laporan hewan hilang yang telah dibuat.",
                    position: "bottom",
                },
                {
                    title: "Menu Laporan Kehilangan Baru",
                    element: "#menu-report",
                    intro: "Gunakan menu ini untuk menambahkan laporan kehilangan baru dengan mudah.",
                    position: "bottom",
                },
                {
                    title: "Laporan Barang Hilang",
                    element: "#add-stuff-missing",
                    intro: "Klik di sini untuk membuat laporan barang hilang.",
                    position: "bottom",
                },
                {
                    title: "Laporan Orang Hilang",
                    element: "#add-person-missing",
                    intro: "Klik di sini untuk membuat laporan orang hilang.",
                    position: "bottom",
                },
                {
                    title: "Laporan Hewan Hilang",
                    element: "#add-animal-missing",
                    intro: "Klik di sini untuk membuat laporan hewan hilang.",
                    position: "bottom",
                },
                {
                    intro: "Itu saja untuk tur singkat ini! Semoga hari Anda menyenangkan!",
                },
            ],
        },

        // -------------------- FORM HEWAN HILANG (USER) --------------------
        "form-animal-missing": {
            key: "tour_animal_done",
            steps: [
                {
                    title: "Selamat Datang!",
                    intro: "Ini adalah panduan singkat mengisi laporan hewan hilang",
                },
                {
                    element: "#nama_hewan",
                    intro: "Masukkan nama panggilan hewan kesayangan Anda",
                    position: "bottom",
                },
                {
                    element: "#jenis_kelamin",
                    intro: "Pilih jenis kelamin hewan",
                    position: "bottom",
                },
                {
                    element: "#deskripsi_hewan",
                    intro: "Jelaskan ciri fisik hewan (warna bulu, tanda khusus, dll)",
                    position: "bottom",
                },
                {
                    element: "#jenis_hewan_select",
                    intro: "Pilih jenis hewan. Bisa tambah baru jika tidak ada",
                    position: "bottom",
                },
                {
                    element: "#ras_select, #input-ras-baru-container",
                    intro: "Pilih atau ketik ras hewan (jika ada)",
                    position: "bottom",
                },
                {
                    element: "[data-characteristics]",
                    intro: "Tambahkan ciri-ciri khusus seperti kalung, tato, mikrochip, dll",
                    position: "bottom",
                },
                {
                    element: "[data-contacts]",
                    intro: "Isi kontak yang bisa dihubungi",
                    position: "bottom",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Tuliskan lokasi terakhir hewan terlihat",
                    position: "bottom",
                },
                {
                    element: "#map-container",
                    intro: "Klik peta untuk menandai lokasi secara akurat",
                    position: "bottom",
                },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Pilih tanggal & jam terakhir kali terlihat",
                    position: "bottom",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Upload foto hewan (maks. 5 foto). Foto sangat membantu!",
                    position: "bottom",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Sebelum kirim, cek apakah laporan serupa sudah ada dengan AI",
                    position: "bottom",
                },
                {
                    intro: "Selesai! Klik 'Kirim Laporan' jika semua sudah terisi",
                },
            ],
        },

        // -------------------- FORM ORANG HILANG (USER) --------------------
        "form-person-missing": {
            key: "tour_person_done",
            steps: [
                {
                    title: "Panduan Laporan Orang Hilang",
                    intro: "Kami bantu sebarkan informasi secepatnya",
                },
                {
                    element: "#nama_orang",
                    intro: "Nama lengkap orang yang hilang",
                    position: "bottom",
                },
                {
                    element: "#deskripsi_orang",
                    intro: "Deskripsikan tinggi, berat badan, pakaian terakhir, dll",
                    position: "bottom",
                },
                {
                    element: "#umur",
                    intro: "Perkiraan umur saat ini",
                    position: "bottom",
                },
                {
                    element: "#jenis_kelamin",
                    intro: "Jenis kelamin",
                    position: "bottom",
                },
                {
                    element: "[data-characteristics]",
                    intro: "Ciri khusus: tato, bekas luka, aksesoris, dll",
                    position: "bottom",
                },
                {
                    element: "[data-contacts]",
                    intro: "Kontak keluarga/polisi yang bisa dihubungi",
                    position: "bottom",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Lokasi terakhir terlihat atau terakhir diketahui",
                    position: "bottom",
                },
                {
                    element: "#map-container",
                    intro: "Tandai lokasi di peta (sangat penting!)",
                    position: "bottom",
                },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Tanggal & jam terakhir terlihat",
                    position: "bottom",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Upload foto terbaru & foto pakaian terakhir",
                    position: "bottom",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Cek duplikat dengan AI agar tidak double report",
                    position: "bottom",
                },
                {
                    intro: "Terima kasih sudah melapor. Semoga cepat ditemukan",
                },
            ],
        },

        // -------------------- FORM BARANG HILANG (USER) --------------------
        "form-stuff-missing": {
            key: "tour_stuff_done",
            steps: [
                {
                    title: "Laporan Barang Hilang",
                    intro: "Ayo buat laporan yang detail agar cepat ketemu!",
                },
                {
                    element: "#nama_barang",
                    intro: "Nama atau jenis barang (misal: Dompet Kulit, Laptop Dell)",
                    position: "bottom",
                },
                {
                    element: "#deskripsi_barang",
                    intro: "Jelaskan detail: warna, merek, nomor seri, isi dompet, dll",
                    position: "bottom",
                },
                {
                    element: "#jenis_barang",
                    intro: "Contoh: Dompet, Tas, Handphone, Kunci Motor, dll",
                    position: "bottom",
                },
                {
                    element: "#merk_barang",
                    intro: "Merk barang (jika ada)",
                    position: "bottom",
                },
                {
                    element: "#warna_barang",
                    intro: "Warna dominan barang",
                    position: "bottom",
                },
                {
                    element: "[data-characteristics]",
                    intro: "Ciri khusus: stiker, goresan, nomor seri, dll",
                    position: "bottom",
                },
                {
                    element: "[data-contacts]",
                    intro: "Kontak yang bisa dihubungi jika ada yang menemukan",
                    position: "bottom",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Lokasi terakhir barang Anda taruh/terlihat",
                    position: "bottom",
                },
                {
                    element: "#map-container",
                    intro: "Tandai lokasi di peta",
                    position: "bottom",
                },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Kapan terakhir Anda ingat memegang barang ini?",
                    position: "bottom",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Foto barang sangat membantu pencarian!",
                    position: "bottom",
                },
                {
                    element: "[data-documents]",
                    intro: "Upload bukti kepemilikan (struk, foto KTP, STNK, dll) – opsional tapi sangat disarankan",
                    position: "bottom",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Cek apakah barang serupa sudah dilaporkan orang lain",
                    position: "bottom",
                },
                {
                    intro: "Laporan selesai! Kami akan sebarkan",
                },
            ],
        },

        // ==================== ADMIN TOURS ====================

        // -------------------- DASHBOARD ADMIN --------------------
        "admin-dashboard": {
            key: "tour_admin_dashboard_done",
            steps: [
                {
                    title: "Selamat Datang di Dashboard Admin InfoHilang!",
                    intro: "Di sini Anda dapat memonitor seluruh laporan kehilangan dan mengelola sistem.",
                },
                {
                    title: "Halaman Dashboard Admin",
                    element: "#dashboard",
                    intro: "Ini adalah dashboard admin. Pantau semua aktivitas laporan kehilangan di sini.",
                    position: "bottom",
                },
                {
                    title: "Memperluas Tampilan",
                    element: "#fullscreen-button",
                    intro: "Klik tombol ini untuk memperluas tampilan dashboard ke layar penuh.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Barang Hilang",
                    element: "#missing-stuff-card",
                    intro: "Total jumlah laporan barang hilang dari seluruh user.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Orang Hilang",
                    element: "#missing-person-card",
                    intro: "Total jumlah laporan orang hilang dari seluruh user.",
                    position: "bottom",
                },
                {
                    title: "Keterangan Hewan Hilang",
                    element: "#missing-animal-card",
                    intro: "Total jumlah laporan hewan hilang dari seluruh user.",
                    position: "bottom",
                },
                {
                    title: "Grafik Traffic Laporan",
                    element: "#admin-charts",
                    intro: "Lihat grafik traffic laporan hilang berdasarkan tanggal. Filter sesuai rentang waktu yang diinginkan.",
                    position: "top",
                },
                {
                    title: "Filter Grafik",
                    element: "#filterChartForm",
                    intro: "Gunakan filter tanggal untuk melihat data laporan pada periode tertentu.",
                    position: "bottom",
                },
                {
                    intro: "Itu saja untuk tur dashboard admin! Gunakan menu sidebar untuk mengelola laporan, user, dan chat.",
                },
            ],
        },

        // -------------------- KELOLA LAPORAN (ADMIN) --------------------
        "admin-manage-report": {
            key: "tour_admin_report_done",
            steps: [
                {
                    title: "Kelola Semua Laporan",
                    intro: "Di halaman ini Anda dapat melihat dan mengelola semua laporan kehilangan dari seluruh user.",
                },
                {
                    title: "Filter Kategori",
                    element: "#filterKategori",
                    intro: "Filter laporan berdasarkan kategori: Orang Hilang, Hewan Hilang, atau Barang Hilang.",
                    position: "bottom",
                },
                {
                    title: "Filter Tanggal",
                    element: "#startDate",
                    intro: "Filter laporan berdasarkan rentang tanggal pembuatan laporan.",
                    position: "bottom",
                },
                {
                    title: "Tombol Filter & Reset",
                    element: "#btnFilter",
                    intro: "Klik tombol Filter untuk menerapkan filter, atau Reset untuk menghapus filter.",
                    position: "bottom",
                },
                {
                    title: "Tabel Data Laporan",
                    element: "#reportsTable",
                    intro: "Tabel ini menampilkan semua laporan. Anda bisa melihat detail atau menghapus laporan yang tidak sesuai.",
                    position: "top",
                },
                {
                    intro: "Selesai! Gunakan fitur ini untuk memantau dan memoderasi laporan pengguna.",
                },
            ],
        },

        // -------------------- MANAJEMEN USER (ADMIN) --------------------
        "admin-manage-user": {
            key: "tour_admin_user_done",
            steps: [
                {
                    title: "Manajemen User",
                    intro: "Di halaman ini Anda dapat mengelola semua user yang terdaftar di sistem InfoHilang.",
                },
                {
                    title: "Filter Tanggal",
                    element: "#startDate",
                    intro: "Filter user berdasarkan tanggal pendaftaran.",
                    position: "bottom",
                },
                {
                    title: "Tombol Filter & Reset",
                    element: "#btnFilter",
                    intro: "Klik tombol Filter untuk menerapkan filter tanggal, atau Reset untuk menghapusnya.",
                    position: "bottom",
                },
                {
                    title: "Tabel Data User",
                    element: "#usersTable",
                    intro: "Tabel ini menampilkan semua user terdaftar. Anda bisa melihat detail atau menghapus user jika diperlukan.",
                    position: "top",
                },
                {
                    intro: "Selesai! Gunakan halaman ini untuk memantau dan mengelola pengguna sistem.",
                },
            ],
        },

        // -------------------- MANAJEMEN CHAT (ADMIN) --------------------
        "admin-chat": {
            key: "tour_admin_chat_done",
            steps: [
                {
                    title: "Manajemen Chat",
                    intro: "Di halaman ini Anda dapat menanggapi chat user ketika AI tidak bisa menjawab pertanyaan mereka.",
                },
                {
                    title: "Daftar User Aktif",
                    element: "#userList",
                    intro: "Daftar user yang sedang atau pernah chat dengan admin. Klik salah satu untuk melihat percakapan.",
                    position: "right",
                },
                {
                    title: "Area Chat",
                    element: "#chatMessages",
                    intro: "Percakapan dengan user akan tampil di sini. Pesan user di sebelah kanan, balasan admin di sebelah kiri.",
                    position: "left",
                },
                {
                    title: "Ketik Balasan",
                    element: "#replyMessage",
                    intro: "Ketik pesan balasan Anda di sini, lalu klik Kirim untuk mengirimkannya ke user.",
                    position: "top",
                },
                {
                    title: "Tandai Selesai",
                    element: "#markHandledBtn",
                    intro: "Setelah selesai menangani chat, klik tombol ini untuk menandai sesi chat sebagai selesai.",
                    position: "bottom",
                },
                {
                    intro: "Selesai! Pastikan untuk selalu merespon chat user dengan cepat dan ramah.",
                },
            ],
        },
    };

    // ============================================================
    //  EKSEKUSI TOUR
    // ============================================================

    // Tentukan tour key berdasarkan halaman dan role
    let tourKey = null;
    let tourConfig = null;

    // Untuk halaman dashboard, bedakan antara admin dan user
    if (page === "dashboard") {
        // Cek apakah user adalah admin (dari meta tag atau data attribute)
        const isAdmin = document.body.dataset.userRole === "admin";
        if (isAdmin) {
            tourKey = "admin-dashboard";
        } else {
            tourKey = "dashboard";
        }
    } else {
        tourKey = page;
    }

    tourConfig = tours[tourKey];
    if (!tourConfig) return;

    // Cek apakah tur sudah pernah ditampilkan
    if (localStorage.getItem(tourConfig.key) === "yes") {
        return;
    }

    // Tunggu sebentar agar semua elemen (termasuk peta) termuat dengan sempurna
    setTimeout(() => {
        introJs()
            .setOptions({
                steps: tourConfig.steps,
                nextLabel: "Lanjut",
                prevLabel: "Kembali",
                doneLabel: "Selesai",
                disableInteraction: true,
                showProgress: true,
                exitOnOverlayClick: false,
                exitOnEsc: true,
                scrollToElement: true,
                scrollPadding: 80,
            })
            .oncomplete(() => localStorage.setItem(tourConfig.key, "yes"))
            .onexit(() => localStorage.setItem(tourConfig.key, "yes"))
            .start();
    }, 800);
});

// ============================================================
//  SSE REAL-TIME DASHBOARD UPDATES
//  Update jumlah laporan (barang, orang, hewan) secara real-time
// ============================================================
(function initSSE() {
    // Hanya jalankan di halaman yang memiliki card laporan (dashboard)
    if (!document.querySelector('#missing-stuff-card, #missing-person-card, #missing-animal-card')) {
        return;
    }

    if (!window.EventSource) {
        console.warn('Browser tidak mendukung SSE (Server-Sent Events)');
        return;
    }

    const sseSource = new EventSource('/sse/dashboard-counts');

    sseSource.onmessage = function (event) {
        try {
            const data = JSON.parse(event.data);

            const stuffCard = document.querySelector('#missing-stuff-card p');
            const personCard = document.querySelector('#missing-person-card p');
            const animalCard = document.querySelector('#missing-animal-card p');

            if (stuffCard && data.missing_items !== undefined) {
                stuffCard.textContent = data.missing_items;
            }
            if (personCard && data.missing_persons !== undefined) {
                personCard.textContent = data.missing_persons;
            }
            if (animalCard && data.missing_animals !== undefined) {
                animalCard.textContent = data.missing_animals;
            }
        } catch (e) {
            console.error('[SSE] Parse error:', e);
        }
    };

    sseSource.onerror = function () {
        console.warn('[SSE] Connection error. Akan reconnect otomatis...');
    };

    // Tutup koneksi saat page unload
    window.addEventListener('beforeunload', function () {
        sseSource.close();
    });
})();
