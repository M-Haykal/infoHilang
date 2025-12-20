/**
 * Toggle sidebar
 */
function toggleSidebar() {
    const sidebar = document.querySelector("aside");
    sidebar.classList.toggle("hidden");
    sidebar.classList.toggle("w-64");
}

function removeField(button) {
    const field = button.closest(".flex");
    if (field) field.remove();
}

function addCiriCiriField() {
    const container = document.getElementById("ciriCiriContainer");
    const div = document.createElement("div");
    div.className = "flex flex-col sm:flex-row gap-2";
    div.innerHTML = `
            <input type="text" name="ciri_ciri_keys[]" placeholder="Nama ciri"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <div class="relative flex-1">
                <input type="text" name="ciri_ciri_values[]" placeholder="Deskripsi"
                    class="w-full px-3 py-2 pl-3 pr-8 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-danger/400 hover:text-danger"
                    onclick="removeField(this.closest('.flex'))">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>`;
    container.appendChild(div);
}

function addKontakField() {
    const container = document.getElementById("kontakContainer");
    const div = document.createElement("div");
    div.className = "flex flex-col sm:flex-row gap-2";
    div.innerHTML = `
            <input type="text" name="kontak_keys[]" placeholder="Jenis kontak"
                class="flex-1 px-3 py-2 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
            <div class="relative flex-1">
                <input type="text" name="kontak_values[]" placeholder="Nomor atau alamat"
                    class="w-full px-3 py-2 pl-3 pr-8 border rounded-lg focus:ring-2 focus:ring-primary focus:border-primary">
                <button type="button" class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-400 hover:text-danger"
                    onclick="removeField(this.closest('.flex'))">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>`;
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
