<?php

$package = [
    'id' => 1,
    'agency_id' => 1,
    'name' => 'Sample Package Name',
    'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent fermentum lectus eu orci hendrerit, ac fringilla felis congue. Aliquam erat volutpat. Proin et elementum massa. Sed vulputate lacus nec lorem facilisis, quis volutpat magna vestibulum. Mauris at lectus ex. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; ',
    'location' => 'Hawaii, USA',
    'price' => 999.99,
    'seats' => 10,
    'occupied_seats' => 0,
    'start_date' => '2025-05-15',
    'end_date' => '2025-05-20',
    'created_at' => '2025-04-01 12:00:00',
    'updated_at' => '2025-04-01 12:00:00',
];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Elite Travel | Package Details</title>

    <!-- Remix Icon (for icons) -->
    <link
            href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
            rel="stylesheet"
    />

    <!-- Swiper CSS (carousel library) -->
    <link
            rel="stylesheet"
            href="https://unpkg.com/swiper/swiper-bundle.min.css"
    />

    <!-- Custom CSS (similar style as before) -->
    <style>
        /*
          ========================================
          GLOBAL STYLES
          ========================================
        */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        html, body {
            scroll-behavior: smooth;
            background: #f5f9ff;
            color: #2b2b2b;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style: none;
        }

        /*
          Color palette from the register/home pages:
          #2891ff, #005bff
        */

        /*
          ========================================
          NAVBAR
          ========================================
        */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(8px);
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .navbar .logo img {
            height: 50px;
            object-fit: contain;
        }
        .nav-links ul {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }
        .nav-links ul li a {
            font-weight: 500;
            padding: 0.5rem 0.8rem;
            transition: color 0.3s;
        }
        .nav-links ul li a:hover {
            color: #005bff;
        }
        .user-actions {
            display: flex;
            gap: 1rem;
        }
        .btn {
            display: inline-block;
            text-align: center;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: transform 0.3s ease, background 0.3s ease;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #ffffff;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #2891ff, #005bff);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.7);
            color: #2891ff;
            border: 1px solid #2891ff;
        }
        .btn-secondary:hover {
            background: #2891ff;
            color: #fff;
            transform: translateY(-2px);
        }

        /*
          ========================================
          HERO SLIDESHOW (Swiper)
          ========================================
        */
        .package-hero {
            margin-top: 76px; /* offset for fixed navbar */
            position: relative;
            width: 100%;
            height: 60vh;
            overflow: hidden;
        }
        .package-hero .swiper {
            width: 100%;
            height: 100%;
        }
        .package-hero .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            background-position: center;
            background-size: cover;
            position: relative;
        }
        /* Dark overlay for text contrast */
        .package-hero .dark-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
        }
        /* Hero content within each slide */
        .hero-content {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
            max-width: 800px;
            padding: 0 1rem;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
        }
        .hero-content p {
            font-size: 1.2rem;
            line-height: 1.4;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }
        /* Swiper controls */
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            transition: color 0.3s ease;
        }
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            color: #2891ff;
        }
        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.7;
        }
        .swiper-pagination-bullet-active {
            background: #2891ff;
            opacity: 1;
        }

        /*
          ========================================
          PACKAGE DETAILS SECTION
          ========================================
        */
        .package-details {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }
        .details-left {
            flex: 1 1 400px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .details-left h2 {
            color: #005bff;
            margin-bottom: 1rem;
        }
        .details-left p {
            line-height: 1.5;
            color: #333;
        }
        .details-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
        }
        .details-item:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .details-item span {
            font-weight: 600;
            color: #005bff;
        }
        .booking-cta {
            margin-top: auto; /* pushes the booking button to bottom */
            text-align: center;
        }
        .booking-cta button {
            padding: 0.8rem 2rem;
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #fff;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.3s, background 0.3s;
        }
        .booking-cta button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #2891ff, #005bff);
        }

        .details-right {
            flex: 1 1 600px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }
        .long-description {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .long-description h3 {
            color: #005bff;
            margin-bottom: 0.5rem;
        }
        .long-description p {
            color: #333;
            line-height: 1.5;
        }

        /*
          ========================================
          PACKAGE GALLERY SECTION
          ========================================
        */
        .package-gallery {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 2rem;
        }
        .package-gallery h3 {
            text-align: center;
            font-size: 1.8rem;
            color: #005bff;
            margin-bottom: 1rem;
        }
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .gallery-grid img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        .gallery-grid img:hover {
            transform: scale(1.02);
        }

        /*
          ========================================
          REVIEWS SECTION
          ========================================
        */
        .reviews-section {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }
        .reviews-section h3 {
            color: #005bff;
            margin-bottom: 1rem;
        }
        .review-card {
            border-bottom: 1px solid #eee;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }
        .review-card:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .review-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }
        .review-header img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .review-author {
            font-weight: 600;
            color: #005bff;
        }
        .review-body {
            color: #333;
            line-height: 1.4;
        }

        /*
          ========================================
          FOOTER
          ========================================
        */
        .footer {
            background: #f5f9ff;
            padding: 2rem;
            border-top: 1px solid #eee;
            margin-top: 3rem;
        }
        .footer .container {
            max-width: 1200px;
            margin: 0 auto;
            text-align: center;
        }
        .footer-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .footer-content .logo img {
            height: 50px;
            object-fit: contain;
        }
        .footer-links {
            display: flex;
            gap: 2rem;
            margin-top: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        .footer-links a {
            color: #2891ff;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            color: #005bff;
        }
        .footer p {
            color: #666;
            font-size: 0.85rem;
        }
        .footer p span {
            color: #2891ff;
            font-weight: 600;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .nav-links ul {
                display: none; /* or build a mobile nav toggle if needed */
            }
            .package-hero {
                height: 40vh;
            }
            .hero-content h1 {
                font-size: 2rem;
            }
            .package-details {
                flex-direction: column;
            }
            .details-left,
            .details-right {
                flex: 1 1 100%;
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar">
    <div class="container">
        <div class="logo">
            <!-- Replace with your actual logo -->
            <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Logo">
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="/travel-packages">Packages</a></li>
                <li><a href="/agencies">Agencies</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/signup" class="btn btn-secondary">Sign Up</a>
        </div>
    </div>
</header>

<!-- Hero Section with Swiper Slideshow -->
<section class="package-hero">
    <div class="swiper myHeroSwiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+1');"
            >
                <!-- Dark overlay for text contrast -->
                <div class="dark-overlay"></div>
                <!-- Content -->
                <div class="hero-content">
                    <!-- Dynamically replace these with the package's name or tagline if you want -->
                    <h1><!-- <?php echo $package['name']; ?> -->Tropical Paradise</h1>
                    <p>Discover the beauty of crystal clear waters and sandy beaches.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+2');"
            >
                <div class="dark-overlay"></div>
                <div class="hero-content">
                    <h1>Tropical Paradise</h1>
                    <p>Unforgettable sunsets await you.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div
                    class="swiper-slide"
                    style="background-image: url('https://via.placeholder.com/1920x800?text=Package+Hero+3');"
            >
                <div class="dark-overlay"></div>
                <div class="hero-content">
                    <h1>Tropical Paradise</h1>
                    <p>Explore island wonders with us.</p>
                </div>
            </div>
            <!-- More slides if needed -->
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Package Details -->
<div class="package-details">
    <!-- Left column: highlights (price, seats, start/end, booking) -->
    <div class="details-left">
        <h2><!-- <?php echo $package['name']; ?> -->Tropical Paradise Getaway</h2>
        <!-- Key data points -->
        <div class="details-item">
            <span>Location:</span>
            <p><!-- <?php echo $package['location']; ?> -->Maldives</p>
        </div>
        <div class="details-item">
            <span>Price:</span>
            <p>$<!-- <?php echo $package['price']; ?> -->1299.00</p>
        </div>
        <div class="details-item">
            <span>Seats Available:</span>
            <p>
                <!-- seats - occupied_seats -->
                12
            </p>
        </div>
        <div class="details-item">
            <span>Start Date:</span>
            <p><!-- <?php echo $package['start_date']; ?> -->2025-07-10</p>
        </div>
        <div class="details-item">
            <span>End Date:</span>
            <p><!-- <?php echo $package['end_date']; ?> -->2025-07-15</p>
        </div>

        <!-- Book Now Button / Form -->
        <div class="booking-cta">
            <form action="/book-package" method="POST" style="display:inline;">
                <!-- In real app: handle CSRF, pass package_id, etc. -->
                <button type="submit">Book Now</button>
            </form>
        </div>
    </div>

    <!-- Right column: longer description, reviews, etc. -->
    <div class="details-right">
        <div class="long-description">
            <h3>About This Package</h3>
            <p>
                <!-- <?php echo nl2br($package['description']); ?> -->
                Escape to an exotic island paradise, where the waters are crystal clear and the sands are pristine white. Enjoy luxurious accommodations, thrilling water sports, and world-class dining as you bask in the tropical sun. From snorkeling through vibrant coral reefs to relaxing in an oceanfront cabana, this experience will leave you rejuvenated and inspired.
            </p>
        </div>

        <!-- Reviews section -->
        <div class="reviews-section">
            <h3>Reviews</h3>

            <!-- Example of looping through reviews -->
            <div class="review-card">
                <div class="review-header">
                    <img
                            src="https://via.placeholder.com/50?text=User"
                            alt="Reviewer Avatar"
                    />
                    <div class="review-author">John Doe</div>
                </div>
                <div class="review-body">
                    "Incredible trip! The beaches were stunning and the resort was top-notch. Highly recommend!"
                </div>
            </div>
            <div class="review-card">
                <div class="review-header">
                    <img
                            src="https://via.placeholder.com/50?text=User"
                            alt="Reviewer Avatar"
                    />
                    <div class="review-author">Jane Smith</div>
                </div>
                <div class="review-body">
                    "Absolutely loved the water activities and the staff were so helpful. Everything was perfect!"
                </div>
            </div>
            <!-- More reviews here, or an "Add Review" form -->
        </div>
    </div>
</div>

<!-- Package Gallery Section -->
<div class="package-gallery">
    <h3>More Views of the Destination</h3>
    <div class="gallery-grid">
        <!-- Replace with actual image URLs / dynamic data -->
        <img src="https://via.placeholder.com/600x400?text=Resort+View" alt="Resort View">
        <img src="https://via.placeholder.com/600x400?text=Beach+Sunset" alt="Beach Sunset">
        <img src="https://via.placeholder.com/600x400?text=Coral+Reef" alt="Coral Reef">
        <img src="https://via.placeholder.com/600x400?text=Outdoor+Lounge" alt="Outdoor Lounge">
        <!-- Add more as needed -->
    </div>
</div>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="logo">
                <!-- Replace with your actual logo -->
                <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Footer Logo">
            </div>
            <nav class="footer-links">
                <a href="/about">About Us</a>
                <a href="/contact">Contact</a>
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </nav>
        </div>
        <p>&copy; <span>2025</span> Elite Travel. All Rights Reserved.</p>
    </div>
</footer>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Custom JS for Swiper Initialization -->
<script>
    // Hero slideshow initialization
    const heroSwiper = new Swiper('.myHeroSwiper', {
        loop: true,
        autoplay: {
            delay: 4000,
        },
        speed: 800,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
</script>

</body>
</html>

