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
