AOS.init();
// Toggle mobile menu
document
    .getElementById("mobile-menu-button")
    .addEventListener("click", function () {
        const mobileMenu = document.getElementById("mobile-menu");
        const menuIcon = this.querySelector(".menu-icon");
        const closeIcon = this.querySelector(".close-icon");
        mobileMenu.classList.toggle("hidden");
        menuIcon.classList.toggle("hidden");
        closeIcon.classList.toggle("hidden");
    });

document
    .getElementById("mobile-profile-button")
    .addEventListener("click", function () {
        const profileDropdown = document.getElementById(
            "mobile-profile-dropdown"
        );
        const profileIcon = document.getElementById("mobile-profile-icon");
        profileDropdown.classList.toggle("hidden");
        profileIcon.classList.toggle("rotate-180");
    });
