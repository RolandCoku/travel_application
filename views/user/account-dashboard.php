<?php
$title = 'Elite Travel - Profile';
$cssFile = 'user/account-dashboard.css';
require_once app_path('includes/layout-header.php'); ?>

    <body class="profile-page">
    <div class="profile-wrapper">
        <!-- Sidebar -->
        <aside class="profile-sidebar">
            <div class="profile-header">
                <img src="/img/assets/user-avatar.png" alt="User Avatar" class="profile-avatar">
                <h2>John Doe</h2>
                <p>johndoe@example.com</p>
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

        <!-- Main Content -->
        <main class="profile-content">
            <!-- Personal Info Section -->
            <section id="info" class="profile-section active">
                <h1>Personal Info</h1>
                <div class="profile-card">
                    <p><strong>Name:</strong> John Doe</p>
                    <p><strong>Email:</strong> johndoe@example.com</p>
                    <p><strong>Phone:</strong> +123 456 789</p>
                </div>
            </section>

            <!-- Bookings Section -->
            <section id="bookings" class="profile-section">
                <h1>Your Bookings</h1>
                <div class="profile-card">
                    <p>You currently have no bookings.</p>
                </div>
            </section>

            <!-- Reviews Section -->
            <section id="reviews" class="profile-section">
                <h1>Your Reviews</h1>
                <div class="profile-card">
                    <p>You haven't written any reviews yet.</p>
                </div>
            </section>

            <!-- Settings Section -->
            <section id="settings" class="profile-section">
                <h1>Account Settings</h1>
                <div class="profile-card">
                    <p>Change your account settings here.</p>
                </div>
            </section>
        </main>
    </div>

    <script>
        // JavaScript to handle menu switching
        document.querySelectorAll('.profile-menu li').forEach(item => {
            item.addEventListener('click', () => {
                document.querySelector('.profile-menu .active').classList.remove('active');
                item.classList.add('active');

                document.querySelector('.profile-section.active').classList.remove('active');
                document.getElementById(item.getAttribute('data-section')).classList.add('active');
            });
        });
    </script>

<?php require_once app_path('includes/layout-footer.php'); ?>