<?php
$title = 'Admin Profile';
$cssFiles = [
    'admin/adminDashboard.css?v=' . time(),
    'admin/adminProfile.css?v=' . time(),
];
require_once app_path('includes/layout-header.php');

// Fetch admin details (replace with actual authentication logic)
//$admin = getLoggedInAdmin(); // Example function to get admin data
$admin = [
    'name' => 'Admin',
    'email' => 'admin@admin.com',
    'role' => 'admin',
    'profile_picture' => 'profile-placeholder.png',
    'created_at' => '2021-01-01 12:00:00',
    'updated_at' => '2021-01-01 12:00:00',
];

?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="profile-header">
            <div class="profile-photo">
                <img src="<?= htmlspecialchars($admin['profile_picture'] ?? 'profile-placeholder.png') ?>"
                     alt="Admin Profile Picture">
            </div>
            <div class="profile-name">
                <h1><?= htmlspecialchars($admin['name']) ?></h1>
                <p class="role"><?= htmlspecialchars(ucfirst($admin['role'])) ?></p>
                <p class="email"><?= htmlspecialchars($admin['email']) ?></p>
            </div>
        </div>

        <div class="profile-details-container">
            <!-- Profile Details -->
            <div class="profile-details">
                <h2>Profile Details</h2>
                <ul>
                    <li><strong>Name:</strong> <?= htmlspecialchars($admin['name']) ?></li>
                    <li><strong>Email:</strong> <?= htmlspecialchars($admin['email']) ?></li>
                    <li><strong>Role:</strong> <?= htmlspecialchars(ucfirst($admin['role'])) ?></li>
                    <li><strong>Account Created:</strong> <?= htmlspecialchars($admin['created_at']) ?></li>
                    <li><strong>Last Updated:</strong> <?= htmlspecialchars($admin['updated_at']) ?></li>
                </ul>
            </div>

            <!-- Action Menu -->
            <div class="profile-actions">
                <h2>Actions</h2>
                <button class="btn-primary" id="edit-profile-btn">Edit Profile</button>
                <button class="btn-secondary" id="change-password-btn">Change Password</button>
            </div>
        </div>
    </main>
</div>

<!-- Edit Profile Modal -->
<div class="modal" id="edit-profile-modal">
    <div class="modal-content">
        <span class="close" id="close-edit-modal">&times;</span>
        <h2>Edit Profile</h2>
        <form id="edit-profile-form">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>

            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal" id="change-password-modal">
    <div class="modal-content">
        <span class="close" id="close-password-modal">&times;</span>
        <h2>Change Password</h2>
        <form id="change-password-form">
            <label for="current-password">Current Password</label>
            <input type="password" id="current-password" name="current_password" required>

            <label for="new-password">New Password</label>
            <input type="password" id="new-password" name="new_password" required>

            <label for="confirm-password">Confirm New Password</label>
            <input type="password" id="confirm-password" name="confirm_password" required>

            <button type="submit" class="btn-primary">Change Password</button>
        </form>
    </div>
</div>

<?php
$jsFiles = [
    'admin/adminProfile.js?v=' . time(),
];
require_once app_path('includes/layout-footer.php');
?>
