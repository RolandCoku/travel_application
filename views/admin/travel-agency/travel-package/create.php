<?php
$title = 'Add New Travel Package';
$cssFiles = [
    '/admin/adminDashboard.css',
    '/admin/travel-agency/travel-package/create.css',
    'boxicons-2.1.4/css/boxicons.min.css'
];
require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/travel-agency-admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Add New Travel Package</h1>
        </div>

        <!-- Add Travel Package Form -->
        <div class="form-container">
            <form id="create-travel-package-form" action="/travel-agency/admin/travel-packages/store" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" rows="4" class="form-control" required></input>
                </div>
                <div class="form-group">
                    <label for="seats">Seat Number</label>
                    <input type="text" id="seats" name="seats" rows="4" class="form-control" required></input>
                </div>

                <div class="form-group row">
                    <div class="col">
                        <label for="start_date">Start Date</label>
                        <input type="date" id="start_date" name="start_date" class="form-control" required />
                    </div>
                    <div class="col">
                        <label for="end_date">End Date</label>
                        <input type="date" id="end_date" name="end_date" class="form-control" required />
                    </div>
                </div>

                <div class="form-group">
                    <div class="col">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" class="form-control" required />
                    </div>
                </div>

                <div class="form-group">
                    <label for="image">Main Image</label>
                    <input type="file" id="image" name="image" class="form-control" required />
                </div>

                <div class="form-group">
                    <label for="secondary_images">Secondary Images</label>
                    <input type="file" id="secondary_images" name="secondary_images[]" class="form-control" multiple required />
                    <small class="text-muted">You can upload up to 4 images.</small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn primary">Create Package</button>
                    <a href="/admin/travel-packages" class="btn secondary">Cancel</a>
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
                    <small class="text-muted">Travel Manager</small>
                </div>
                <div class="profile-photo">
                    <img src="person2.png" alt="Profile Picture"/>
                </div>
            </div>
        </div>
        <div class="sales-analytics">
            <div class="info item">
                <i class='bx bx-info-circle' style="font-size: 50px; color: #7380ec"></i>
                <h2>Fill out the field to register a new travel package to your agency</h2>
            </div>
        </div>

    </div>
</div>

<?php
$jsFile = '/admin/adminDashboard.js';
require_once app_path('includes/layout-footer.php'); ?>
