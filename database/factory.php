<?php

require_once __DIR__ . '/../config/db_connection.php';
global $conn;

function seedUsersTable($conn): void
{
    echo PHP_EOL . "Seeding users table...";
    for ($i = 0; $i < 50; $i++) {
        $name = "User $i";
        $email = "user$i@example.com";
        $password = password_hash("password$i", PASSWORD_DEFAULT);
        $role = $i % 2 === 0 ? 'admin' : 'user';
        $emailConfirmed = mt_rand(0, 1);

        $query = "INSERT INTO users (name, email, password, role, email_confirmed) VALUES ('$name', '$email', '$password', '$role', $emailConfirmed)";
        $conn->query($query);
    }
}

function seedAgenciesTable($conn): void
{
    echo PHP_EOL . "Seeding agencies table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(12, 50);
        $name = "Agency $i";
        $description = "Description of Agency $i";
        $address = "Address $i";
        $phone = "1234567890";
        $website = "https://agency$i.com";

        $query = "INSERT INTO agencies (user_id, name, description, address, phone, website) 
                  VALUES ('$userId', '$name', '$description', '$address', '$phone', '$website')";
        $conn->query($query);
    }
}

function seedTravelPackagesTable($conn): void
{
    echo PHP_EOL . "Seeding travel_packages table...";
    for ($i = 0; $i < 50; $i++) {
        $agencyId = mt_rand(10, 50);
        $name = "Package $i";
        $description = "Description of Package $i";
        $location = "Location $i";
        $price = mt_rand(100, 10000) / 100;
        $seats = mt_rand(1, 50);
        $occupied_seats = mt_rand(0, $seats);
        $startDate = date('Y-m-d', strtotime("+$i days"));
        $endDate = date('Y-m-d', strtotime("+$i days +7 days"));

        $query = "INSERT INTO travel_packages (agency_id, name, description, location, price, seats, occupied_seats, start_date, end_date) 
                  VALUES ($agencyId, '$name', '$description', '$location', '$price', '$seats', '$occupied_seats', '$startDate', '$endDate')";
        $conn->query($query);
    }
}

function seedCategoriesTable($conn): void
{
    echo PHP_EOL . "Seeding categories table...";
    for ($i = 0; $i < 50; $i++) {
        $name = "Category $i";

        $query = "INSERT INTO categories (name) VALUES ('$name')";
        $conn->query($query);
    }
}

function seedBookingsTable($conn): void
{
    echo PHP_EOL . "Seeding bookings table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(20, 50);
        $travelPackageId = mt_rand(1, 50);
        $bookingDate = date('Y-m-d', strtotime("+$i days"));
        $bookingStatus = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];

        $query = "INSERT INTO bookings (user_id, travel_package_id, booking_date, booking_status, booked_seats) 
                  VALUES ($userId, $travelPackageId, '$bookingDate', '$bookingStatus', 1)";
        $conn->query($query);
    }
}

function seedReviewsTable($conn): void
{
    echo PHP_EOL . "Seeding reviews table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(1, 50);
        $travelPackageId = mt_rand(1, 50);
        $rating = mt_rand(1, 5);
        $comment = "This is a review comment for Package $travelPackageId";

        $query = "INSERT INTO reviews (user_id, travel_package_id, rating, comment) 
                  VALUES ($userId, $travelPackageId, '$rating', '$comment')";
        $conn->query($query);
    }
}

function seedLogsTable($conn): void
{
    echo PHP_EOL . "Seeding logs table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(1, 50);
        $action = "Action $i";

        $query = "INSERT INTO logs (user_id, action) VALUES ($userId, '$action')";
        $conn->query($query);
    }
}

function seedCategoryTravelPackageTable($conn): void
{
    echo PHP_EOL . "Seeding category_travel_package table...";
    for ($i = 0; $i < 50; $i++) {
        $categoryId = mt_rand(1, 50);
        $travelPackageId = mt_rand(1, 50);

        $query = "INSERT INTO category_travel_package (category_id, travel_package_id) 
                  VALUES ($categoryId, $travelPackageId)";
        $conn->query($query);
    }
}

function seedImagesTable($conn): void
{
    echo PHP_EOL . "Seeding images table...";

    $images = [
        'agency-1.webp',
        'agency-2.webp',
        'agency-3.webp',
        'agency-4.webp',
        'agency-5.webp',
        'agency-6.webp',
        'agency-7.webp',
        'agency-8.webp',
        'agency-9.webp',
    ];

    // Add images for agencies
    $agencyCount = $conn->query("SELECT COUNT(*) as count FROM agencies")->fetch_assoc()['count'];

    for ($agencyId = 1; $agencyId <= $agencyCount; $agencyId++) {
        // Add main image
        $mainImageUrl = $images[($agencyId - 1) % count($images)];
        $mainAltText = "Main image for Agency $agencyId";
        $query = "INSERT INTO images (entity_type, entity_id, image_url, alt_text, type) 
                  VALUES ('agency', $agencyId, '$mainImageUrl', '$mainAltText', 'main')";
        $conn->query($query);

        // Add four secondary images
        for ($j = 1; $j <= 4; $j++) {
            $secondaryImageUrl = $images[($agencyId + $j - 1) % count($images)];
            $secondaryAltText = "Secondary image $j for Agency $agencyId";
            $query = "INSERT INTO images (entity_type, entity_id, image_url, alt_text, type) 
                      VALUES ('agency', $agencyId, '$secondaryImageUrl', '$secondaryAltText', 'secondary')";
            $conn->query($query);
        }
    }

    // Add images for travel packages
    $packageCount = $conn->query("SELECT COUNT(*) as count FROM travel_packages")->fetch_assoc()['count'];

    for ($packageId = 1; $packageId <= $packageCount; $packageId++) {
        // Add main image
        $mainImageUrl = $images[($packageId - 1) % count($images)];
        $mainAltText = "Main image for Travel Package $packageId";
        $query = "INSERT INTO images (entity_type, entity_id, image_url, alt_text, type) 
                  VALUES ('travel_package', $packageId, '$mainImageUrl', '$mainAltText', 'main')";
        $conn->query($query);

        // Add four secondary images
        for ($j = 1; $j <= 4; $j++) {
            $secondaryImageUrl = $images[($packageId + $j - 1) % count($images)];
            $secondaryAltText = "Secondary image $j for Travel Package $packageId";
            $query = "INSERT INTO images (entity_type, entity_id, image_url, alt_text, type) 
                      VALUES ('travel_package', $packageId, '$secondaryImageUrl', '$secondaryAltText', 'secondary')";
            $conn->query($query);
        }
    }

    echo PHP_EOL . "Seeding images table complete.";
}

function seedPaymentsTable($conn): void
{
    echo PHP_EOL . "Seeding payments table...";
    for ($i = 0; $i < 50; $i++) {
        $bookingId = mt_rand(1, 50);
        $paypalOrder = "PAY-$i";
        $amount = mt_rand(100, 10000) / 100;
        $status = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];

        $query = "INSERT INTO payments (booking_id, paypal_order_id, amount, payment_status) 
                  VALUES ($bookingId, '$paypalOrder', '$amount', '$status')";
        $conn->query($query);
    }
}

function seedDatabase($conn): void
{
    seedUsersTable($conn);
    seedAgenciesTable($conn);
    seedTravelPackagesTable($conn);
    seedCategoriesTable($conn);
    seedBookingsTable($conn);
    seedReviewsTable($conn);
    seedLogsTable($conn);
    seedCategoryTravelPackageTable($conn);
    seedImagesTable($conn);

    seedPaymentsTable($conn);

    echo PHP_EOL . "Seeding complete.";
}

// Run the seeder
seedDatabase($conn);
