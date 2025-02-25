<?php
$title = 'Admin Dashboard';
$cssFiles = [
    'admin/adminDashboard.css?v=' . time(),
];
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>


<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/travel-agency-admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Reviews</h1>
        </div>

        <!--Reviews  -->
        <div class="recent-orders">
            <table>
                <thead>
                <tr>
                    <th>User Name</th>
                    <th>Package Name</th>
                    <th>Comment</th>
                    <th>Rating</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody id="reviews-table-body">
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
                    <img src="../../../index.php" alt="Profile Picture"/>
                </div>
            </div>
        </div>

        <div class="recent-updates">
            <h2>Latest Reviews</h2>
            <div class="update">
                <p><b>John Smith</b> just booked a trip to New York.</p>
                <small class="text-muted">2 minutes ago</small>
            </div>
            <div class="update">
                <p><b>Jane Doe</b> left a 5-star review for Paris package.</p>
                <small class="text-muted">1 hour ago</small>
            </div>
        </div>
    </div>
</div>

<?php
$jsFile = '/adminDashboard.js';
require_once app_path('includes/layout-footer.php');
?>



