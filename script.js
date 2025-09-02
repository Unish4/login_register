function showForm(formId) {
    document.querySelectorAll(".form-box").forEach(form => {
        form.classList.add("hidden"); // hide all forms
        form.classList.remove("block"); // remove block if present
    });

    const activeForm = document.getElementById(formId);
    activeForm.classList.remove("hidden"); // show selected form
    activeForm.classList.add("block");
}
