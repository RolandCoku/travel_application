<?php

require_once __DIR__ . '/../config/db_connection.php';

global $conn;

function seedDatabase($conn): void
{
    // Seed users table
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

    // Seed agencies table
    echo PHP_EOL . "Seeding agencies table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(1, 50);
        $name = "Agency $i";
        $description = "Description of Agency $i";
        $address = "Address $i";
        $phone = "1234567890";
        $email = "agency$i@agency.com";
        $website = "https://agency$i.com";

        $query = "INSERT INTO agencies (user_id, name, description, address, phone, email, website) 
                  VALUES ('$userId', '$name', '$description', '$address', '$phone', '$email', '$website')";
        $conn->query($query);
    }

    // Seed travel_packages table
    echo PHP_EOL . "Seeding travel_packages table...";
    for ($i = 0; $i < 50; $i++) {
        $agencyId = mt_rand(1, 50);
        $name = "Package $i";
        $description = "Description of Package $i";
        $price = mt_rand(100, 10000) / 100;
        $startDate = date('Y-m-d', strtotime("+$i days"));
        $endDate = date('Y-m-d', strtotime("+$i days +7 days"));

        $query = "INSERT INTO travel_packages (agency_id, name, description, price, start_date, end_date) 
                  VALUES ($agencyId, '$name', '$description', $price, '$startDate', '$endDate')";
        $conn->query($query);
    }

    // Seed categories table
    echo PHP_EOL . "Seeding categories table...";
    for ($i = 0; $i < 50; $i++) {
        $name = "Category $i";

        $query = "INSERT INTO categories (name) VALUES ('$name')";
        $conn->query($query);
    }

    // Seed bookings table
    echo PHP_EOL . "Seeding bookings table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(1, 50);
        $travelPackageId = mt_rand(1, 50);
        $bookingDate = date('Y-m-d', strtotime("+$i days"));
        $bookingStatus = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];

        $query = "INSERT INTO bookings (user_id, travel_package_id, booking_date, booking_status) 
                  VALUES ($userId, $travelPackageId, '$bookingDate', '$bookingStatus')";
        $conn->query($query);
    }

    // Seed reviews table
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

//    // Seed payments table
//    echo PHP_EOL . "Seeding payments table...";
//    for ($i = 0; $i < 50; $i++) {
//        $bookingId = mt_rand(1, 50);
//        $paymentDate = date('Y-m-d', strtotime("+$i days"));
//        $paymentStatus = ['pending', 'approved', 'rejected'][array_rand(['pending', 'approved', 'rejected'])];
//
//        $query = "INSERT INTO payments (booking_id, payment_date, payment_status)
//                  VALUES ($bookingId, '$paymentDate', '$paymentStatus')";
//        $conn->query($query);
//    }

    // Seed logs table
    echo PHP_EOL . "Seeding logs table...";
    for ($i = 0; $i < 50; $i++) {
        $userId = mt_rand(1, 50);
        $action = "Action $i";

        $query = "INSERT INTO logs (user_id, action) VALUES ($userId, '$action')";
        $conn->query($query);
    }

    // Seed category_travel_package pivot table
    echo PHP_EOL . "Seeding category_travel_package table...";
    for ($i = 0; $i < 50; $i++) {
        $categoryId = mt_rand(1, 50);
        $travelPackageId = mt_rand(1, 50);

        $query = "INSERT INTO category_travel_package (category_id, travel_package_id) 
                  VALUES ($categoryId, $travelPackageId)";
        $conn->query($query);
    }

    // Seed images table
    echo PHP_EOL . "Seeding images table...";
    for ($i = 0; $i < 50; $i++) {
        $travelPackageId = mt_rand(1, 50);
        $imageUrl = "https://example.com/image$i.jpg";
        $altText = "Image $i";
        $type = $i % 2 === 0 ? 'main' : 'secondary';

        $query = "INSERT INTO images (travel_package_id, image_url, alt_text, type) 
                  VALUES ($travelPackageId, '$imageUrl', '$altText', '$type')";
        $conn->query($query);
    }

    echo PHP_EOL . "Seeding complete.";
}

// Run the seeder
seedDatabase($conn);
