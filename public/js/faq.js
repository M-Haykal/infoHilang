document.addEventListener("DOMContentLoaded", function () {
    const faqs = [
        {
            question: "Apa itu InfoHilang?",
            answer: "InfoHilang adalah platform komunitas untuk membantu menemukan orang, hewan, atau barang yang hilang melalui sistem laporan publik dan peta lokasi.",
        },
        {
            question: "Apakah saya harus login untuk membuat laporan?",
            answer: "Tidak wajib, namun dengan akun Anda bisa mengedit laporan, menerima pesan langsung dari penemu, dan mendapatkan notifikasi perkembangan terbaru secara real-time.",
        },
        {
            question: "Apakah identitas saya aman?",
            answer: "Sangat aman. Nomor HP dan email Anda tidak ditampilkan ke publik. Komunikasi dilakukan melalui sistem chat internal di dalam platform kami.",
        },
        {
            question: "Bagaimana cara melaporkan temuan?",
            answer: "Klik tombol 'Buat Laporan' lalu pilih kategori 'Ditemukan'. Kami akan mencocokkan data Anda dengan laporan kehilangan yang ada di sistem kami.",
        },
        {
            question: "Apakah InfoHilang menarik biaya?",
            answer: "Tidak ada biaya sama sekali (Gratis). Platform ini dibangun sebagai bentuk gotong royong antar sesama anggota masyarakat.",
        },
    ];

    const faqList = document.getElementById("faq-list");

    faqList.innerHTML = faqs
        .map(
            (faq, index) => `
            <div class="faq-item group transition-all duration-300 bg-white border brounded-2xl overflow-hidden hover:shadow-md">
                <button type="button"
                        class="faq-btn flex items-center justify-between w-full px-6 py-5 text-left outline-none focus:outline-none focus-visible:ring-2 focus-visible:ring-inset transition-all duration-300">
                    <span class="text-lg font-bold text-dark group-hover:text-accent transition-colors duration-300 tracking-tight">
                        ${faq.question}
                    </span>
                    <i class="fa-solid fa-chevron-down text-netral-400 transition-transform duration-300 text-sm"></i>
                </button>
                <div class="faq-answer hidden px-6 pb-6 text-netral-500 leading-relaxed">
                    <div class="pt-4 border-t border-netral-100">
                        ${faq.answer}
                    </div>
                </div>
            </div>
        `,
        )
        .join("");

    const buttons = document.querySelectorAll(".faq-btn");

    buttons.forEach((btn) => {
        btn.addEventListener("click", () => {
            const answer = btn.nextElementSibling;
            const parent = btn.parentElement;
            const questionText = btn.querySelector("span");

            // Cek apakah item ini sudah terbuka
            const isAlreadyOpen = !answer.classList.contains("hidden");

            // Tutup SEMUA FAQ yang lagi terbuka
            document
                .querySelectorAll(".faq-answer")
                .forEach((el) => el.classList.add("hidden"));
            document.querySelectorAll(".faq-btn span").forEach((span) => {
                span.classList.remove("text-accent");
                span.classList.add("text-dark");
            });
            document.querySelectorAll(".faq-item").forEach((item) => {
                item.classList.remove(
                    "border-accent",
                    "ring-1",
                    "ring-accent",
                    "shadow-md",
                );
            });

            // Kalau sebelumnya tertutup, buka yang diklik
            if (!isAlreadyOpen) {
                answer.classList.remove("hidden");
                parent.classList.add(
                    "border-accent",
                    "ring-1",
                    "ring-accent",
                    "shadow-md",
                );
                questionText.classList.remove("text-dark");
                questionText.classList.add("text-accent");
            }
        });
    });
});
