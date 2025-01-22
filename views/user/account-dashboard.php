<?php
$title = 'Elite Travel | Account Dashboard';
$cssFiles = [
    'user/account-dashboard.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body>
<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- PROFILE WRAPPER -->
<div class="profile-page-wrapper">

    <!-- LEFT SIDEBAR -->
    <aside class="profile-sidebar">
        <div class="profile-header">
            <img
                    src="/img/<?php if (isset($user_profile_data)) echo $user_profile_data['profile_picture']['image_url'] ?? 'assets/logo-2.png' ?>"
                    alt="<?= $user_profile_data['profile_picture']['alt_text'] ?? 'default' ?>"
                    class="profile-avatar"
            >
            <h2><?php echo $user_profile_data['name'] ?></h2>
            <p><?= $user_profile_data['email'] ?></p>
        </div>
        <nav class="profile-menu">
            <ul>
                <li data-section="info" class="active">Personal Info</li>
                <li data-section="bookings">Bookings</li>
                <li data-section="reviews">Reviews</li>
                <li data-section="settings">Settings</li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="profile-content">
        <!-- Personal Info Section -->
        <section id="info" class="profile-section active">
            <h1>Personal Info</h1>
            <div class="profile-card">
                <p><strong>Name:</strong> <?= $user_profile_data['name'] ?></p>
                <p><strong>Email:</strong> <?= $user_profile_data['email'] ?></p>
                <button class="btn btn-primary" data-modal="edit-profile">Edit Profile</button>
            </div>
        </section>

        <!-- Bookings Section -->
        <section id="bookings" class="profile-section">
            <h1>Your Bookings</h1>
            <div class="booking-grid">
                <?php foreach ($user_profile_data['bookings'] as $booking): ?>
                    <div class="booking-card">
                        <img src="/img/<?= $booking['travel_package']['main_image']['image_url'] ?? 'assets/agencies/agency-1.webp' ?>"
                             alt="Package <?= $booking['travel_package']['main_image']['alt_text'] ?? 'default' ?>">
                        <h4>Package Name: <?= $booking['travel_package']['name'] ?></h4>
                        <p><strong>Date:</strong> <?= $booking['booking_date'] ?></p>
                        <p><strong>Status:</strong> <?= ucfirst($booking['status']) ?></p>
                        <a href="/bookings/details/<?= $booking['id'] ?>" class="btn">View Details</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" class="profile-section">
            <h1>Your Reviews</h1>
            <p>No reviews yet.</p>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="profile-section">
            <h1>Account Settings</h1>
            <button class="btn btn-primary" data-modal="change-password">Change Password</button>
        </section>
    </main>
</div>

<!-- EDIT PROFILE MODAL -->
<div id="edit-profile-modal" class="modal hidden">
    <div class="modal-content">
        <h2>Edit Profile</h2>
        <form action="/user/update" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="profile-photo">Profile Photo</label>
                <input type="file" name="profile_picture" id="profile-photo" accept="image/*">
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" value="<?= $user_profile_data['name'] ?>" placeholder="Name">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?= $user_profile_data['email'] ?>" placeholder="Email">
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <button type="reset" class="btn btn-secondary close-modal">Cancel</button>
        </form>
    </div>
</div>

<!-- CHANGE PASSWORD MODAL -->
<div id="change-password-modal" class="modal hidden">
    <div class="modal-content">
        <h2>Change Password</h2>
        <form action="/user/change-password" method="POST">
            <input type="password" name="current_password" placeholder="Current Password" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit" class="btn btn-primary">Change Password</button>
            <button type="reset" class="btn btn-secondary close-modal">Cancel</button>
        </form>
    </div>
</div>
<!-- JS to Switch Sections and Handle Modals -->
<script>
    // Handle section switching
    document.querySelectorAll('.profile-menu li').forEach(menuItem => {
        menuItem.addEventListener('click', () => {
            document.querySelector('.profile-menu li.active')?.classList.remove('active');
            menuItem.classList.add('active');
            document.querySelector('.profile-section.active')?.classList.remove('active');
            document.getElementById(menuItem.getAttribute('data-section')).classList.add('active');
        });
    });

    // Handle modals
    const modals = document.querySelectorAll('.modal');
    document.querySelectorAll('[data-modal]').forEach(btn => {
        btn.addEventListener('click', () => {
            document.getElementById(`${btn.dataset.modal}-modal`).classList.remove('hidden');
        });
    });
    document.querySelectorAll('.close-modal').forEach(btn => {
        btn.addEventListener('click', () => {
            modals.forEach(modal => modal.classList.add('hidden'));
        });
    });
</script>

</body>
</html>
