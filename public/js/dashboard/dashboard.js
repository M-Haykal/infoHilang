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


function changePreview(element, imageUrl) {
    // ganti gambar utama
    const mainPreview = document.getElementById('main-preview');
    mainPreview.style.opacity = '0';

    setTimeout(() => {
        mainPreview.src = imageUrl;
        mainPreview.style.opacity = '1';
    }, 150);

    // reset semua border thumbnail
    document.querySelectorAll('.thumbnail-item').forEach(img => {
        img.classList.remove('border-primary', 'ring-2', 'ring-blue-300');
        img.classList.add('border-transparent');
    });

    // tambahin border ke thumbnail yang diklik
    element.classList.add('border-primary', 'ring-2', 'ring-blue-300');
    element.classList.remove('border-transparent');
}

function copyToClipboard(element, text) {
    navigator.clipboard.writeText(text).then(() => {

        const badge = element.querySelector('.copy-badge');

        badge.classList.remove('translate-y-full');
        badge.classList.add('translate-y-0');

        // hide lagi setelah 1.5 detik
        setTimeout(() => {
            badge.classList.remove('translate-y-0');
            badge.classList.add('translate-y-full');
        }, 1500);

    }).catch(err => {
        console.error('Gagal menyalin: ', err);
    });
}
