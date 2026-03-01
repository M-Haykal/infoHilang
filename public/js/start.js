function initAOS() {
    AOS.init({
        once: true,
        duration: 800,
        easing: "ease-in-out",
    });
}

// Jalankan saat pertama kali load
document.addEventListener("DOMContentLoaded", initAOS);

// Refresh AOS setiap kali Livewire selesai update DOM
document.addEventListener("livewire:updated", () => {
    // delay sedikit agar Livewire selesai merender tinggi elemen
    setTimeout(() => {
        AOS.refresh();
    }, 100);
});

// Toggle mobile menu
document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("user-menu-button");
    const dropdown = document.getElementById("user-dropdown");
    const icon = document.getElementById("dropdown-icon");

    if (btn && dropdown) {
        btn.addEventListener("click", function (event) {
            event.stopPropagation();
            // Toggle Class Hidden
            dropdown.classList.toggle("hidden");
        });

        // Klik di luar dropdown untuk menutup
        window.addEventListener("click", function (e) {
            if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add("hidden");
            }
        });
    }
});
