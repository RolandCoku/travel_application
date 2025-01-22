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
            <h1>Travel Packages</h1>
        </div>
        <!-- Registered users  -->
        <div class="recent-orders">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Agency</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Duration</th>
                    <th>Free Seats</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="travel-packages-table-body">
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
                    <img src="person2.png" alt="Profile Picture"/>
                </div>
            </div>
        </div>

        <div class="sales-analytics">
            <h2>Top Packages</h2>
            <div class="item">
                <div>
                    <h3>Paris</h3>
                    <p>250 bookings</p>
                </div>
            </div>
            <div class="item">
                <div>
                    <h3>Bali</h3>
                    <p>200 bookings</p>
                </div>
            </div>
            <div class="item">
                <div>
                    <h3>New York</h3>
                    <p>180 bookings</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$jsFiles = [
    'admin/travelPackages.js'
];
require_once app_path('includes/layout-footer.php');
?>



