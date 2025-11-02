/**
 * Toggle sidebar
 */
function toggleSidebar() {
    const sidebar = document.querySelector("aside");
    sidebar.classList.toggle("hidden");
    sidebar.classList.toggle("w-64");
}

function addCiriCiriField() {
    const container = document.getElementById("ciriCiriContainer");
    const div = document.createElement("div");
    div.className = "flex flex-col sm:flex-row gap-2";
    div.innerHTML = `
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>`;
    container.appendChild(div);
}

function addKontakField() {
    const container = document.getElementById("kontakContainer");
    const div = document.createElement("div");
    div.className = "flex flex-col sm:flex-row gap-2";
    div.innerHTML = `
            <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <button type="button" class="px-3 py-2 bg-danger text-white rounded-lg hover:bg-red-500"
                onclick="removeField(this)">Hapus</button>`;
    container.appendChild(div);
}

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".reply-toggle-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const commentId = this.dataset.commentId;
            const form = document.getElementById(`reply-form-${commentId}`);
            form.classList.toggle("hidden");
            if (!form.classList.contains("hidden")) {
                form.querySelector("textarea").focus();
            }
        });
    });

    document.querySelectorAll(".cancel-reply-btn").forEach((button) => {
        button.addEventListener("click", function () {
            const form = this.closest(".reply-form");
            form.classList.add("hidden");
            form.querySelector("textarea").value = "";
        });
    });
});
