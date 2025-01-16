<?php
$title = 'Booking Details';
$cssFiles = [
    '/admin/adminDashboard.css',
    '/admin/travel-agency/booking/show.css',
    'boxicons-2.1.4/css/boxicons.min.css'
];

$booking = [
    'id' => 1,
    'user_name' => 'John Doe',
    'user_email' => 'john@doe.com',
    'travel_package_name' => 'Paris Tour',
    'booking_date' => '2021-08-15',
    'booking_status' => 'approved',
    'payment_amount' => 1500,
    'payment_status' => 'paid'
];

$package = [
    'name' => 'Paris Tour',
    'description' => 'Explore the city of love, Paris, with our guided tour.',
    'price' => 1500,
    'duration' => 5,
    'seats' => 20,
    'occupied_seats' => 5,
    'start_date' => '2021-09-01',
    'end_date' => '2021-09-05'
];



require_once app_path('includes/layout-header.php'); ?>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"/>

<div class="container">
    <!-- Sidebar -->
    <?php require_once app_path('includes/travel-agency-admin-sidebar.php'); ?>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Booking Details</h1>
        </div>

        <!-- Booking Details Section -->
        <div class="details-container">
            <div class="details-header">
                <h2>Booking Information</h2>
            </div>
            <div class="details-content">
                <div class="detail-item">
                    <span class="label">Client Name:</span>
                    <span class="value"><?= $booking['user_name'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Client Email:</span>
                    <span class="value"><?= $booking['user_email'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Travel Package Name:</span>
                    <span class="value"><?= $booking['travel_package_name'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Booking Date:</span>
                    <span class="value"><?= $booking['booking_date'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Booking Status:</span>
                    <span class="value <?= $booking['booking_status'] ?>"><?= ucfirst($booking['booking_status']) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Payment Amount:</span>
                    <span class="value">$<?= number_format($booking['payment_amount'], 2) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Payment Status:</span>
                    <span class="value <?= $booking['payment_status'] ?>"><?= ucfirst($booking['payment_status']) ?></span>
                </div>
            </div>
        </div>

        <!-- Travel Package Information Section -->
        <div class="details-container">
            <div class="details-header">
                <h2>Travel Package Information</h2>
            </div>
            <div class="details-content">
                <div class="detail-item">
                    <span class="label">Package Name:</span>
                    <span class="value"><?= $package['name'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Description:</span>
                    <span class="value"><?= $package['description'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Price:</span>
                    <span class="value">$<?= number_format($package['price'], 2) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Duration:</span>
                    <span class="value"><?= $package['duration'] ?> days</span>
                </div>
                <div class="detail-item">
                    <span class="label">Available Seats:</span>
                    <span class="value"><?= $package['seats'] - $package['occupied_seats'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Start Date:</span>
                    <span class="value"><?= $package['start_date'] ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">End Date:</span>
                    <span class="value"><?= $package['end_date'] ?></span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="form-actions">
            <a href="/admin/bookings/edit?id=<?= $booking['id'] ?>" class="btn primary">Edit Booking</a>
            <a href="/admin/bookings" class="btn secondary">Back to Bookings</a>
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
    </div>
</div>

<?php
$jsFile = '/admin/adminDashboard.js';
require_once app_path('includes/layout-footer.php'); ?>

<style>
    .details-container {
        background: var(--color-white);
        padding: var(--card-padding);
        border-radius: var(--card-border-radius);
        box-shadow: var(--box-shadow);
        margin: 2rem 0;
    }

    .details-header {
        border-bottom: 1px solid var(--color-light);
        padding-bottom: 0.8rem;
        margin-bottom: 1rem;
    }

    .details-content {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
    }

    .detail-item .label {
        font-weight: 500;
        color: var(--color-dark);
        margin-bottom: 0.5rem;
    }

    .detail-item .value {
        font-size: 1rem;
        color: var(--color-dark-variant);
    }

    .detail-item .value.pending {
        color: var(--color-warning);
    }

    .detail-item .value.approved {
        color: var(--color-success);
    }

    .detail-item .value.rejected {
        color: var(--color-danger);
    }

    .form-actions {
        margin-top: 2rem;
        display: flex;
        justify-content: space-between;
    }

    .form-actions .btn {
        padding: 0.8rem 1.6rem;
        border: none;
        border-radius: var(--border-radius-1);
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 300ms ease;
    }

    .form-actions .btn.primary {
        background: var(--color-primary);
        color: var(--color-white);
    }

    .form-actions .btn.primary:hover {
        background: var(--color-primary-variant);
    }

    .form-actions .btn.secondary {
        background: var(--color-light);
        color: var(--color-dark);
    }

    .form-actions .btn.secondary:hover {
        background: var(--color-info-light);
    }
</style>
