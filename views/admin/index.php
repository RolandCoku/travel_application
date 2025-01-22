<?php
$title = 'Admin Dashboard';
$cssFiles = [
    'admin/adminDashboard.css?v=' . time(),
];
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>


<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/admin-sidebar.php'); ?>
    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Admin Dashboard</h1>
        </div>

        <div class="insights">
            <div class="bookings">
                <h2 class="text-muted"> Last 7 days </h2>
                <div class="middle">
                    <span class="material-icons-sharp"> flight </span>
                    <div class="left">
                        <h1></h1>
                        <h3>Total Bookings</h3>
                    </div>
                </div>
            </div>

            <div class="expenses">
                <h2 class="text-muted"> Last 7 days </h2>
                <div class="middle">
                    <span class="material-icons-sharp"> bar_chart </span>
                    <div class="left">
                        <h1></h1>
                        <h3>Total Income</h3>
                    </div>
                </div>
            </div>

            <div class="new-users">
                <h2 class="text-muted"> Last 7 days </h2>
                <div class="middle">
                    <span class="material-icons-sharp"> group </span>
                    <div class="left">
                        <h1></h1>
                        <h3>New Users</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registered users  -->
        <div class="recent-orders">
            <h2>Registered Users</h2>
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Email Confirmed</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="users-table-body">
                <!-- Data will be loaded here using JS -->
                </tbody>
            </table>
            <div id="pagination-container" class="pagination">
                <!-- Pagination buttons will be dynamically added here -->
            </div>
        </div>
    </main>

    <!-- Right Sidebar -->
    <div class="right">
        <div class="top">
            <button id="menu-btn">
                <span class="material-icons-sharp"> menu </span>
            </button>
            <div class="profile">
                <div class="info">
                    <p>Hello, <b>Admin</b></p>
                    <small class="text-muted">Travel Manager</small>
                </div>
                <div class="profile-photo">
                    <img src="person2.png" alt="Profile Picture" />
                </div>
            </div>
        </div>

        <div class="recent-updates">
            <h2>Latest Updates</h2>
        </div>

        <div class="sales-analytics">
            <h2>Top Destinations</h2>
        </div>
    </div>
</div>

<?php
$jsFiles = [
    'admin/adminDashboard.js?v=' . time(),
];
require_once app_path('includes/layout-footer.php');
?>



