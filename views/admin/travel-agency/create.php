<?php
$title = 'Add New Travel Agency';
$cssFiles = [
    '/admin/adminDashboard.css',
    '/admin/travel-agency/create.css',
    'boxicons-2.1.4/css/boxicons.min.css'
];
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Add New Travel Agency</h1>
        </div>

        <!-- Add Travel Agency Form -->
        <div class="form-container">
            <form id="create-agency-form" action="/admin/travel-agencies/store" method="POST">
                <div class="form-group">
                    <label for="email">Admin</label>
                    <!-- Search field for admin email -->
                    <input type="email" id="email" name="email" class="form-control" required />
                    <div id="suggestions-container" class="suggestions"></div>
                </div>


                <div class="form-group">
                    <label for="name">Agency Name</label>
                    <input type="text" id="name" name="name" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" id="website" name="website" class="form-control" required />
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Register a new agency</button>
                    <a href="/admin/agencies" class="btn secondary">Cancel</a>
                </div>
            </form>
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
                    <small class="text-muted">System Manager</small>
                </div>
                <div class="profile-photo">
                    <img src="person2.png" alt="Profile Picture"/>
                </div>
            </div>
        </div>
        <div class="sales-analytics">
            <div class="info item">
                <i class='bx bx-plus-circle' style="font-size: 50px; color: #7380ec"></i>
                <h2>Register a new travel agency under an admin's supervision</h2>
            </div>
        </div>
    </div>
</div>

<?php

$jsFiles = [
    '/admin/travel-agency/create.js?v=' . time(),
];
require_once app_path('includes/layout-footer.php'); ?>

