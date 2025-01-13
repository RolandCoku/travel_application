<?php include app_path('includes/layout-header.php'); ?>

<h1>Payment</h1>

<!-- This form should be opened when the user clicks book on a travel package -->

<form action="/bookings/store" method="POST">
    <input type="hidden" name="travel_package_id" value="<?= $_GET['travel_package_id'] ?>">
    <input type="hidden" name="user_id" value="<?= $_SESSION['user_id'] ?>">
    <div class="form-group row">
        <div class="col">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" required>
        </div>
    </div>
    <!-- <div class="form-group row">
        <div class="col">
            <label for="payment_method">Payment Method</label>
            <select name="payment_method" id="payment_method" class="form-control" required>
                <option value="">Select Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="paypal">Paypal</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="card_number">Card Number</label>
            <input type="text" name="card_number" id="card_number" class="form-control" required>
        </div>
        <div class="col">
            <label for="expiry_date">Expiry Date</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control" required>
        </div>
    </div> -->
    <!-- <div class="form-group row">
        <div class="col">
            <label for="cvv">CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control" required>
        </div>
    </div> -->
    <div class="form-group mt-3">
        <button type="submit" class="btn btn-primary">Book</button>
    </div>
</form>

<?php include app_path('includes/layout-footer.php'); ?>
