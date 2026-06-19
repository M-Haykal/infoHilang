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
        '[data-page="dashboard"], [data-page="form-animal-missing"], [data-page="form-person-missing"], [data-page="form-stuff-missing"]',
    );
    if (!pageElement) return;

    const page = pageElement.dataset.page;

    // ============================================================
    //  DEFINISI TOUR UNTUK SEMUA HALAMAN (sudah di-uncomment semua)
    // ============================================================
    const tours = {
        // -------------------- DASHBOARD --------------------
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

        // -------------------- FORM HEWAN HILANG --------------------
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
                    element: "#map-container", // perbaiki selector
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

        // -------------------- FORM ORANG HILANG --------------------
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
                    element: "#map-container", // perbaiki selector
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

        // -------------------- FORM BARANG HILANG --------------------
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
                    element: "#map-container", // perbaiki selector
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
    };

    // ============================================================
    //  EKSEKUSI TOUR
    // ============================================================
    const tourConfig = tours[page];
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
                disableInteraction: true, // mencegah interaksi selama tur (opsional)
                showProgress: true,
                exitOnOverlayClick: false,
                exitOnEsc: true,
                scrollToElement: true, // aktifkan scroll otomatis ke elemen
                scrollPadding: 80, // beri jarak 80px dari atas agar tidak terlalu menempel
            })
            .oncomplete(() => localStorage.setItem(tourConfig.key, "yes"))
            .onexit(() => localStorage.setItem(tourConfig.key, "yes"))
            .start();
    }, 800); // delay 800ms cukup untuk AOS dan peta
});
