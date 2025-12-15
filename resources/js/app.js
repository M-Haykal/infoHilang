import "./bootstrap";
import Echo from "laravel-echo";
import Alpine from "alpinejs";
import Pusher from "pusher-js";
import introJs from "intro.js";
import "intro.js/introjs.css";
import 'select2';
import 'select2/dist/css/select2.min.css';

window.Pusher = Pusher;
window.Alpine = Alpine;
window.introJs = introJs;

window.Echo = new Echo({
    broadcaster: "pusher",
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
});

document.addEventListener("DOMContentLoaded", () => {
    const pageElement = document.querySelector(
        '[data-page="dashboard"], [data-page="form-animal-missing"], [data-page="form-person-missing"], [data-page="form-stuff-missing"]'
    );
    if (!pageElement) return;

    const page = pageElement.dataset.page;

    const tours = {
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
                },
                {
                    title: "Keterangan Barang Hilang",
                    element: "#missing-stuff-card",
                    intro: "Jumlah laporan barang hilang yang telah dibuat.",
                },
                {
                    title: "Keterangan Orang Hilang",
                    element: "#missing-person-card",
                    intro: "Jumlah laporan orang hilang yang telah dibuat.",
                },
                {
                    title: "Keterangan Hewan Hilang",
                    element: "#missing-animal-card",
                    intro: "Jumlah laporan hewan hilang yang telah dibuat.",
                },
                {
                    title: "Menu Laporan Kehilangan Baru",
                    element: "#menu-report",
                    intro: "Gunakan menu ini untuk menambahkan laporan kehilangan baru dengan mudah.",
                },
                {
                    title: "Laporan Barang Hilang",
                    element: "#add-stuff-missing",
                    intro: "Klik di sini untuk membuat laporan barang hilang.",
                },
                {
                    title: "Laporan Orang Hilang",
                    element: "#add-person-missing",
                    intro: "Klik di sini untuk membuat laporan orang hilang.",
                },
                {
                    title: "Laporan Hewan Hilang",
                    element: "#add-animal-missing",
                    intro: "Klik di sini untuk membuat laporan hewan hilang.",
                },
                {
                    intro: "Itu saja untuk tur singkat ini! Semoga hari Anda menyenangkan!",
                },
            ],
        },
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
                },
                {
                    element: "#deskripsi_hewan",
                    intro: "Jelaskan ciri fisik hewan (warna bulu, tanda khusus, dll)",
                },
                {
                    element: "#jenis_hewan_select",
                    intro: "Pilih jenis hewan. Bisa tambah baru jika tidak ada",
                },
                {
                    element: "#ras-container, #ras-manual-container",
                    intro: "Pilih atau ketik ras hewan (jika ada)",
                },
                {
                    element: "[data-characteristics]",
                    intro: "Tambahkan ciri-ciri khusus seperti kalung, tato, mikrochip, dll",
                },
                {
                    element: "[data-contacts]",
                    intro: "Isi kontak yang bisa dihubungi",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Tuliskan lokasi terakhir hewan terlihat",
                },
                {
                    element: ".map-container",
                    intro: "Klik peta untuk menandai lokasi secara akurat",
                },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Pilih tanggal & jam terakhir kali terlihat",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Upload foto hewan (maks. 5 foto). Foto sangat membantu!",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Sebelum kirim, cek apakah laporan serupa sudah ada dengan AI",
                },
                {
                    intro: "Selesai! Klik 'Kirim Laporan' jika semua sudah terisi",
                },
            ],
        },

        "form-person-missing": {
            key: "tour_person_done",
            steps: [
                {
                    title: "Panduan Laporan Orang Hilang Hilang",
                    intro: "Kami bantu sebarkan informasi secepatnya",
                },
                {
                    element: "#nama_orang",
                    intro: "Nama lengkap orang yang hilang",
                },
                {
                    element: "#deskripsi_orang",
                    intro: "Deskripsikan tinggi, berat badan, pakaian terakhir, dll",
                },
                { element: "#umur", intro: "Perkiraan umur saat ini" },
                { element: "#jenis_kelamin", intro: "Jenis kelamin" },
                {
                    element: "[data-characteristics]",
                    intro: "Ciri khusus khusus: tato, bekas luka, aksesoris, dll",
                },
                {
                    element: "[data-contacts]",
                    intro: "Kontak keluarga/polisi yang bisa dihubungi",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Lokasi terakhir terlihat atau terakhir diketahui",
                },
                {
                    element: ".map-container",
                    intro: "Tandai lokasi di peta (sangat penting!)",
                },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Tanggal & jam terakhir terlihat",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Upload foto terbaru & foto pakaian terakhir",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Cek duplikat dengan AI agar tidak double report",
                },
                { intro: "Terima kasih sudah melapor. Semoga cepat ditemukan" },
            ],
        },

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
                },
                {
                    element: "#deskripsi_barang",
                    intro: "Jelaskan detail: warna, merek, nomor seri, isi dompet, dll",
                },
                {
                    element: "#jenis_barang",
                    intro: "Contoh: Dompet, Tas, Handphone, Kunci Motor, dll",
                },
                { element: "#merk_barang", intro: "Merk barang (jika ada)" },
                { element: "#warna_barang", intro: "Warna dominan barang" },
                {
                    element: "[data-characteristics]",
                    intro: "Ciri khusus: stiker, goresan, nomor seri, dll",
                },
                {
                    element: "[data-contacts]",
                    intro: "Kontak yang bisa dihubungi jika ada yang menemukan",
                },
                {
                    element: "#lokasi_terakhir_dilihat",
                    intro: "Lokasi terakhir barang Anda taruh/terlihat",
                },
                { element: ".map-container", intro: "Tandai lokasi di peta" },
                {
                    element: "#tanggal_terakhir_dilihat",
                    intro: "Kapan terakhir Anda ingat memegang barang ini?",
                },
                {
                    element: "[data-photo-upload]",
                    intro: "Foto barang sangat membantu pencarian!",
                },
                {
                    element: "[data-documents]",
                    intro: "Upload bukti kepemilikan (struk, foto KTP, STNK, dll) – opsional tapi sangat disarankan",
                },
                {
                    element: "#check-duplicate-btn",
                    intro: "Cek apakah barang serupa sudah dilaporkan orang lain",
                },
                { intro: "Laporan selesai! Kami akan sebarkan" },
            ],
        },
    };

    const tourConfig = tours[page];

    if (!tourConfig) return;

    if (localStorage.getItem(tourConfig.key) === "yes") {
        return;
    }

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
            })
            .oncomplete(() => localStorage.setItem(tourConfig.key, "yes"))
            .onexit(() => localStorage.setItem(tourConfig.key, "yes"))
            .start();
    }, 800);
});

Alpine.start();
