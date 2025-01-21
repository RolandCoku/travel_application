<?php
$title = 'Elite Travel | Checkout';
$cssFiles = [
    'user/booking/create.css?=v' . time()
];
require_once app_path('includes/layout-header.php');
?>

<body>
<!-- Navbar -->
<?php require_once app_path('includes/user-navbar.php'); ?>

<!-- Hero / Banner -->
<section class="package-hero">
    <div class="dark-overlay"></div>
    <div class="hero-content">
        <h1>Confirm Your Booking</h1>
        <p>Review the package details and proceed to secure your spot.</p>
    </div>
</section>


<!-- Checkout Section -->
<section class="checkout-section">
        <!-- Package Details Card -->
        <div class="card package-details-card">
            <!-- Main Image -->
            <div class="card-image">
                <img src="/img/<?= $data['main_image']['image_url'] ?>"
                     alt="<?= $data['main_image']['alt_text'] ?>"
                     loading="lazy">
            </div>

            <!-- Package Details -->
            <div class="card-content">
                <h2><?= $data['name'] ?></h2>
                <p><?= $data['description'] ?></p>
                <div class="location-container">
                    <strong>Location:</strong> <?= $data['location'] ?>
                </div>
                <p><strong>Duration:</strong> <?= $data['start_date'] ?> to <?= $data['end_date'] ?></p>
                <p><strong>Price per Seat:</strong> $<?= $data['price'] ?></p>
                <p><strong>Available Seats:</strong> <?= $data['free_seats'] ?></p>
                <p><strong>Agency:</strong> <?= $data['agency']['name'] ?></p>
                <p><strong>Contact:</strong> <?= $data['agency']['email'] ?> | <?= $data['agency']['phone'] ?></p>
                <p><strong>Address:</strong> <?= $data['agency']['address'] ?></p>
                <p><strong>Average Rating:</strong> <?= str_repeat('⭐', $data['average_rating']) ?></p>
            </div>
        </div>

    <!-- Total Price and Checkout Form -->
    <div class="card total-price-card">
        <h2>Total Price</h2>
        <p><strong>Price per Seat:</strong> $<?= $data['price'] ?></p>
        <div class="seats-input-container">
            <label for="seats_booked">Seats Booked:</label>
            <button type="button" class="btn-control" onclick="updateSeats(-1)">-</button>
            <input type="text" id="seats_booked" name="seats_booked" value="<?= $selectedSeats ?? 1 ?>" readonly>
            <button type="button" class="btn-control" onclick="updateSeats(1)">+</button>
        </div>
        <hr>
        <p><strong>Total:</strong> $<span id="total_price"><?= $data['price'] * ($selectedSeats ?? 1) ?></span></p>
        <form action="/bookings/store" method="POST">
            <input type="hidden" name="travel_package_id" value="<?= $data['id'] ?>">
            <input type="hidden" name="price_per_seat" value="<?= $data['price'] ?>">
            <input type="hidden" id="form_seats_booked" name="seats_booked" value="<?= $selectedSeats ?? 1 ?>">
            <input type="hidden" id="form_total_price" name="total_price" value="<?= $data['price'] * ($selectedSeats ?? 1) ?>">
            <button type="submit" class="btn btn-primary">Proceed to Payment</button>
        </form>
    </div>
</section>

<script>
    function updateSeats(change) {
        const seatsInput = document.getElementById('seats_booked');
        const totalPriceElement = document.getElementById('total_price');
        const formSeatsBooked = document.getElementById('form_seats_booked');
        const formTotalPrice = document.getElementById('form_total_price');
        const pricePerSeat = <?= $data['price'] ?>;
        const maxSeats = <?= $data['free_seats'] ?>;
        let seatsBooked = parseInt(seatsInput.value);

        // Update seat count within allowed range
        seatsBooked = Math.min(Math.max(seatsBooked + change, 1), maxSeats);

        // Update input and total price
        seatsInput.value = seatsBooked;
        const totalPrice = seatsBooked * pricePerSeat;
        totalPriceElement.textContent = totalPrice.toFixed(2);

        // Update hidden form inputs
        formSeatsBooked.value = seatsBooked;
        formTotalPrice.value = totalPrice.toFixed(2);
    }
</script>

<!-- Footer -->
<?php require_once app_path('includes/layout-footer.php'); ?>
</body>
