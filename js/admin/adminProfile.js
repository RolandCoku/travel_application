document.addEventListener("DOMContentLoaded", () => {
    const editProfileBtn = document.getElementById("edit-profile-btn");
    const changePasswordBtn = document.getElementById("change-password-btn");

    const editProfileModal = document.getElementById("edit-profile-modal");
    const changePasswordModal = document.getElementById("change-password-modal");

    const closeEditModal = document.getElementById("close-edit-modal");
    const closePasswordModal = document.getElementById("close-password-modal");

    // Show modals
    editProfileBtn.addEventListener("click", () => editProfileModal.style.display = "flex");
    changePasswordBtn.addEventListener("click", () => changePasswordModal.style.display = "flex");

    // Hide modals
    closeEditModal.addEventListener("click", () => editProfileModal.style.display = "none");
    closePasswordModal.addEventListener("click", () => changePasswordModal.style.display = "none");

    // Handle form submissions (mocked example, replace with actual logic)
    document.getElementById("edit-profile-form").addEventListener("submit", (e) => {
        e.preventDefault();
        alert("Profile updated successfully!");
        editProfileModal.style.display = "none";
    });

    document.getElementById("change-password-form").addEventListener("submit", (e) => {
        e.preventDefault();
        alert("Password changed successfully!");
        changePasswordModal.style.display = "none";
    });
});
