// simplified selector: no modal, just use current logged-in user's kontak

function toggleContactInputs(disable) {
    document.querySelectorAll('[name^="kontak"]').forEach((el) => {
        el.disabled = disable;
    });
    const extra = document.querySelector("[data-contacts]");
    if (extra) extra.style.display = disable ? "none" : "";
}

function useMyProfileContacts() {
    const hidden = document.getElementById("selected_user_id");
    if (hidden) hidden.value = window.currentUserId || "";
    const label = document.getElementById("selected-user-label");
    if (label) label.textContent = window.currentUserName || "";
    toggleContactInputs(true);

    // disable and update button so user knows it's been applied
    const btn = document.querySelector(
        'button[onclick="useMyProfileContacts()"]',
    );
    if (btn) {
        btn.textContent = "Kontak profil digunakan";
        btn.disabled = true;
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const hidden = document.getElementById("selected_user_id");
    if (hidden && hidden.value) {
        toggleContactInputs(true);
        const btn = document.querySelector(
            'button[onclick="useMyProfileContacts()"]',
        );
        if (btn) {
            btn.textContent = "Kontak profil digunakan";
            btn.disabled = true;
        }
    }
});
