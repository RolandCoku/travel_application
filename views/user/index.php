<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elite Travel</title>

    <style>
        /* General Body Styling */
        body.homepage {
            background: url('/img/assets/homepage-background.jpg') no-repeat center center/cover;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
        }

        /* Navbar */
        .navbar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background: rgba(0, 0, 0, 0.7);
            position: fixed;
            width: 100%;
            z-index: 10;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(10px);
        }

        .navbar .logo img {
            max-width: 150px;
        }

        .navbar .nav-links ul {
            list-style: none;
            display: flex;
            gap: 20px;
            padding: 0;
            margin: 0;
        }

        .navbar .nav-links a {
            text-decoration: none;
            color: #ffffff;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .navbar .nav-links a:hover {
            color: #2891ff;
        }

        .navbar .user-actions {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        /* Hero Section */
        .hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
            color: #ffffff;
            background: linear-gradient(135deg, rgba(0, 91, 255, 0.7), rgba(40, 145, 255, 0.7)),
            url('/img/assets/hero-background.jpg') no-repeat center center/cover;
        }

        .hero .hero-slider {
            position: relative;
            width: 100%;
            overflow: hidden;
        }

        .hero .slide {
            min-width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            animation: slideFade 5s infinite;
            background-size: cover;
            background-position: center;
            text-align: center;
        }

        .hero .hero-text {
            animation: fadeIn 2s ease-in-out;
        }

        .hero h1 {
            font-size: 4rem;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            margin-bottom: 20px;
        }

        .hero .btn {
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #ffffff;
            transition: transform 0.3s, background 0.3s;
            cursor: pointer;
        }

        .hero .btn:hover {
            background: linear-gradient(135deg, #2891ff, #005bff);
            transform: translateY(-5px);
        }

        /* Animations */
        @keyframes slideFade {
            0% {opacity: 0;}
            25% {opacity: 1;}
            50% {opacity: 1;}
            100% {opacity: 0;}
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }

        /* Travel Packages */
        .travel-packages {
            padding: 60px 20px;
            background: rgba(255, 255, 255, 0.1);
            text-align: center;
        }

        .travel-packages h2 {
            font-size: 2.5rem;
            color: #ffffff;
            margin-bottom: 30px;
        }

        .packages-row {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding: 10px;
            scroll-behavior: smooth;
        }

        .packages-scroll {
            display: flex;
            gap: 20px;
        }

        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.5);
        }

        .card img {
            max-width: 100%;
            border-radius: 8px;
        }

        .card h3 {
            font-size: 1.5rem;
            color: #ffffff;
            margin: 15px 0 10px;
        }

        .card p {
            color: #dddddd;
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }

            .navbar {
                flex-direction: column;
                padding: 10px 20px;
            }

            .nav-links ul {
                flex-direction: column;
                gap: 10px;
            }

            .travel-packages h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
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