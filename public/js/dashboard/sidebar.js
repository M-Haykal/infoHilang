/**
 * Toggle sidebar
 */
function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    const overlay = document.getElementById("sidebar-overlay");

    sidebar.classList.toggle("-translate-x-full");
    overlay.classList.toggle("hidden");
}

/**
 * Toggle fullscreen
 */

function toggleFullScreen() {
    const fullscreenButton = document.getElementById("fullscreen-button");
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen();
        localStorage.setItem("fullscreen", "true");
        fullscreenButton.innerHTML = "<i class='fas fa-compress'></i>";
    } else {
        document.exitFullscreen();
        localStorage.setItem("fullscreen", "false");
        fullscreenButton.innerHTML = "<i class='fas fa-expand'></i>";
    }
}
