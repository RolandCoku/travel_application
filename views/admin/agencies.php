<?php
$title = 'Admin Dashboard';
$cssFiles = [
        'admin/adminDashboard.css?v=' . time()
];
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>


<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Travel Agencies</h1>
        </div>
        <!-- Registered users  -->
        <div class="recent-orders">
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="agencies-table-body">
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
            <h2>Top Agencies</h2>
        </div>
        <!-- Register a new agency link -->
        <div class="sales-analytics">
            <div class="item" style="background-color: lightcoral">
                <div>
                    <h3 style="padding-bottom: 5px"><a href="/admin/travel-agencies/register">Register New Agency</a></h3>
                    <p class="text-muted">Add a new travel agency to the system.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$jsFiles = [
        'admin/agencies.js?v=' . time(),
];
require_once app_path('includes/layout-footer.php');
?>
