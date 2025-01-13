<?php
$title = 'Elite Travel | Home';
$cssFile = 'user/index.css?=v' . time();
require_once app_path('includes/layout-header.php');
?>
<body class="homepage">
<!-- Navbar -->
<header class="navbar">
    <div class="container">
        <div class="logo">
            <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Logo">
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="/agencies">Agencies</a></li>
                <li><a href="/travel-packages">Travel Packages</a></li>
                <li><a href="/reviews">Reviews</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/signup" class="btn btn-secondary">Sign Up</a>
        </div>
    </div>
</header>

<!-- Hero Section -->
<section class="hero">
    <div class="hero-content">
        <h1>Your Next Adventure Awaits</h1>
        <p>Explore the world's most beautiful destinations with Elite Travel.</p>
        <a href="/book-now" class="btn btn-primary">Book Now</a>
    </div>
</section>

<!-- Travel Packages Section -->
<section class="travel-packages">
    <div class="container">
        <h2>Featured Travel Packages</h2>
        <div class="card-container">
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Beach+Paradise" alt="Beach Paradise">
                <h3>Beach Paradise</h3>
                <p>Relax on the most pristine beaches.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Mountain+Retreat" alt="Mountain Retreat">
                <h3>Mountain Retreat</h3>
                <p>Rejuvenate in the serene mountains.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=City+Explorer" alt="City Explorer">
                <h3>City Explorer</h3>
                <p>Discover vibrant cityscapes.</p>
            </div>
        </div>
    </div>
</section>

<!-- Agencies Section -->
<section class="agencies">
    <div class="container">
        <h2>Our Trusted Agencies</h2>
        <div class="card-container">
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Global+Travel+Co." alt="Global Travel Co.">
                <h3>Global Travel Co.</h3>
                <p>Experts in global travel solutions.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Adventure+Tours" alt="Adventure Tours">
                <h3>Adventure Tours</h3>
                <p>Adventure awaits with us.</p>
            </div>
            <div class="card">
                <img src="https://via.placeholder.com/300x200?text=Luxury+Escapes" alt="Luxury Escapes">
                <h3>Luxury Escapes</h3>
                <p>Indulge in luxurious vacations.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="logo">
                <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Footer Logo">
            </div>
            <nav class="footer-links">
                <a href="/about">About Us</a>
                <a href="/contact">Contact</a>
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </nav>
        </div>
        <p>&copy; 2025 Elite Travel. All Rights Reserved.</p>
    </div>
</footer>
</body>
</html>