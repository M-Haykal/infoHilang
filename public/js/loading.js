/**
 * Loading Animation
 */
document.addEventListener("DOMContentLoaded", function () {
    const loader = document.getElementById("global-loader");
    if (loader) {
        // Tambahkan delay kecil agar animasi terlihat
        setTimeout(() => {
            loader.style.opacity = "0";
            setTimeout(() => {
                loader.style.display = "none";
            }, 500);
        }, 300);
    }
});
