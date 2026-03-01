// remove Livewire listener; we now fetch data via AJAX

let globalFetchUsers;

function renderUsers(users) {
    const listContainer = document.getElementById("user-contact-list");
    if (!listContainer) return;
    if (users.length === 0) {
        listContainer.innerHTML = `
                <div class="p-8 text-center text-netral-400">
                    <i class="fa-solid fa-inbox text-4xl mb-3 block"></i>
                    <p>Tidak ada pengguna yang ditemukan</p>
                </div>`;
        return;
    }
    listContainer.innerHTML = "";
    users.forEach((user) => {
        const userDiv = document.createElement("div");
        userDiv.className = "p-4 hover:bg-netral-50 transition cursor-pointer";
        let kontakHtml = "";
        Object.entries(user.kontak || {}).forEach(([platform, value]) => {
            if (value && value !== "-" && value.toString().trim() !== "") {
                kontakHtml += `<span class="inline-block mr-2 text-xs text-netral-600">${platform}</span>`;
            }
        });

        userDiv.innerHTML = `
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="font-semibold text-dark">${user.name}</p>
                        <p class="text-sm text-netral-500">${user.email}</p>
                    </div>
                </div>
                <div class="space-y-1">${kontakHtml}</div>
            `;

        userDiv.addEventListener("click", function () {
            selectUserForContacts(user.id, user.name);
            closeUserContactModal();
        });

        listContainer.appendChild(userDiv);
    });
}

function fetchUsers(query = "") {
    fetch(`/dashboard/user-contacts?search=${encodeURIComponent(query)}`)
        .then((res) => res.json())
        .then((data) => renderUsers(data))
        .catch((err) => console.error("user contact fetch error", err));
}

document.addEventListener("DOMContentLoaded", function () {
    globalFetchUsers = fetchUsers;
    const searchInput = document.getElementById("user-contact-search");
    if (searchInput) {
        searchInput.addEventListener("input", () => {
            fetchUsers(searchInput.value);
        });
    }

    // If the page was reloaded with a previously selected user, disable inputs
    const hidden = document.getElementById("selected_user_id");
    if (hidden && hidden.value) {
        // also update the visible label if not already set
        const label = document.getElementById("selected-user-label");
        if (label && !label.textContent.trim()) {
            // no reliable name available here; leave it to blade to render
        }
        toggleContactInputs(true);
    }
});

function openUserContactSelector(type = "all") {
    console.log("openUserContactSelector called, type=", type);
    showUserContactModal();
}

function showUserContactModal() {
    // clear previously selected
    const hidden = document.getElementById("selected_user_id");
    if (hidden) hidden.value = "";
    toggleContactInputs(false);
    // also clear any visible label
    const label = document.getElementById("selected-user-label");
    if (label) label.textContent = "";

    const modal = document.getElementById("user-contact-modal");
    if (modal) {
        modal.classList.remove("hidden");
        const search = document.getElementById("user-contact-search");
        if (search) search.value = "";
        const list = document.getElementById("user-contact-list");
        if (list)
            list.innerHTML = `<div class="p-8 text-center text-netral-400"><i class="fa-solid fa-inbox text-4xl mb-3 block"></i><p>Mulai mengetik untuk mencari pengguna</p></div>`;
    }
    // load initial users (empty query)
    if (typeof globalFetchUsers === "function") {
        globalFetchUsers("");
    }
}

function closeUserContactModal() {
    const modal = document.getElementById("user-contact-modal");
    if (modal) modal.classList.add("hidden");
}

function selectUserForContacts(userId, userName) {
    const hidden = document.getElementById("selected_user_id");
    if (hidden) hidden.value = userId;
    // optionally show selected user name somewhere
    const label = document.getElementById("selected-user-label");
    if (label) label.textContent = userName;

    toggleContactInputs(true);
}

function toggleContactInputs(disable) {
    // disable or enable all inputs in contact section (static and dynamic)
    document.querySelectorAll('[name^="kontak"]').forEach((el) => {
        el.disabled = disable;
    });
    // if disabling, you may hide the dynamic contacts component as well
    const extra = document.querySelector("[data-contacts]");
    if (extra) extra.style.display = disable ? "none" : "";
}

function populateContactField(platform, value) {
    const kontakInput = document.querySelector(
        `input[name="kontak[${platform}]"]`,
    );
    if (kontakInput) {
        kontakInput.value = value;
        kontakInput.dispatchEvent(new Event("change", { bubbles: true }));
        return;
    }
    if (value) {
        const container = document.getElementById("kontakContainer");
        if (container) {
            let found = false;
            container.querySelectorAll(".grid").forEach((row) => {
                const keyInput = row.querySelector(
                    'input[name="kontak_keys[]"]',
                );
                const valueInput = row.querySelector(
                    'input[name="kontak_values[]"]',
                );
                if (
                    keyInput &&
                    valueInput &&
                    keyInput.value.trim().toLowerCase() ===
                        platform.trim().toLowerCase()
                ) {
                    valueInput.value = value;
                    found = true;
                }
            });
            if (!found) {
                addKontakField();
                const lastRow = container.lastElementChild;
                if (lastRow) {
                    const keyInput = lastRow.querySelector(
                        'input[name="kontak_keys[]"]',
                    );
                    const valueInput = lastRow.querySelector(
                        'input[name="kontak_values[]"]',
                    );
                    if (keyInput) keyInput.value = platform;
                    if (valueInput) valueInput.value = value;
                }
            }
        }
    }
}

// copy all kontak key/values from user into form
function populateAllContacts(kontaks) {
    Object.entries(kontaks || {}).forEach(([platform, value]) => {
        if (value && value !== "-" && value.toString().trim() !== "") {
            populateContactField(platform, value);
        }
    });
}
