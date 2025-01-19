<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Elite Travel | Home</title>

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

    <!-- Custom CSS -->
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
            background: #f5f9ff; /* Light background for contrast */
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
          Color palette & gradient references from register page
          Primary colors: #2891ff, #005bff
          We'll use them for backgrounds, buttons, etc.
        */

        /*
          Glass effect snippet (for reference):
          background: rgba(255, 255, 255, 0.6);
          box-shadow: 0 10px 30px rgba(255, 255, 255, 0.5);
          backdrop-filter: blur(10px);
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
        .navbar .search-bar {
            flex: 1;
            margin: 0 2rem;
            max-width: 400px;
            position: relative;
        }
        .navbar .search-bar input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #2891ff;
            border-radius: 25px;
            outline: none;
            font-size: 0.9rem;
            background-color: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(4px);
            transition: box-shadow 0.3s ease;
        }
        .navbar .search-bar input:focus {
            box-shadow: 0 0 5px 2px rgba(0, 91, 255, 0.2);
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
          HERO SLIDESHOW (using Swiper)
          ========================================
        */
        .hero-section {
            position: relative;
            width: 100%;
            height: 80vh;
            margin-top: 76px; /* to compensate for fixed navbar */
        }
        .swiper-container {
            width: 100%;
            height: 100%;
        }
        .swiper-slide {
            display: flex;
            align-items: center;
            justify-content: center;
            background-position: center;
            background-size: cover;
            position: relative;
        }
        .swiper-slide .caption {
            position: absolute;
            bottom: 10%;
            left: 5%;
            color: #fff;
            font-size: 2rem;
            font-weight: bold;
            max-width: 500px;
            animation: slideIn 1s ease forwards;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.7);
        }
        /* Next/Prev arrows */
        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            transition: color 0.3s ease;
        }
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            color: #2891ff;
        }
        /* Pagination bullets */
        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.8;
        }
        .swiper-pagination-bullet-active {
            background: #2891ff;
            opacity: 1;
        }

        @keyframes slideIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /*
          ========================================
          FEATURED AGENCY (horizontal slider)
          ========================================
        */
        .section-agency {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-agency h2 {
            font-size: 2rem;
            color: #005bff;
            margin-bottom: 1.5rem;
        }
        .swiper-agency {
            position: relative;
        }
        .swiper-agency .swiper-wrapper {
            padding-bottom: 3rem;
        }
        .swiper-agency .swiper-slide {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            cursor: grab;
            transition: transform 0.3s ease;
        }
        .swiper-agency .swiper-slide img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .swiper-agency .swiper-slide:hover {
            transform: translateY(-5px);
        }
        .agency-content {
            padding: 1rem;
        }
        .agency-content h3 {
            margin: 0.5rem 0;
            color: #005bff;
            font-size: 1.2rem;
        }
        .agency-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /*
          ========================================
          TRAVEL PACKAGES (horizontal slider)
          ========================================
        */
        .section-packages {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .section-packages h2 {
            font-size: 2rem;
            color: #005bff;
            margin-bottom: 1.5rem;
        }
        .swiper-packages .swiper-slide {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            cursor: grab;
            transition: transform 0.3s ease;
        }
        .swiper-packages .swiper-slide img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .swiper-packages .swiper-slide:hover {
            transform: translateY(-5px);
        }
        .package-content {
            padding: 1rem;
        }
        .package-content h3 {
            margin: 0.5rem 0;
            color: #005bff;
            font-size: 1.2rem;
        }
        .package-content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        /*
          ========================================
          REVIEWS SECTION
          ========================================
        */
        .review-container {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            max-width: 1200px;
            margin: 3rem auto;
            padding: 0 2rem;
            align-items: center;
            justify-content: space-between;
        }
        .container-left {
            flex: 1 1 380px;
            min-width: 300px;
        }
        .container-left h2 {
            font-size: 2rem;
            color: #005bff;
            margin-bottom: 1rem;
        }
        .container-left p {
            margin-bottom: 1rem;
            color: #333;
            line-height: 1.5;
        }
        .container-left button {
            padding: 0.8rem 1.2rem;
            font-size: 1rem;
            color: #fff;
            border: none;
            border-radius: 30px;
            background: linear-gradient(135deg, #005bff, #2891ff);
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
        }
        .container-left button:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #2891ff, #005bff);
        }

        .container-right {
            flex: 1 1 500px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
            min-width: 300px;
        }
        .container-right .card {
            background: rgba(255, 255, 255, 0.6);
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            gap: 1rem;
            padding: 1rem;
        }
        .container-right .card img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }
        .card-content {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            flex: 1;
        }
        .card-content span i {
            font-size: 1.5rem;
            color: #2891ff;
        }
        .card-details p {
            font-size: 0.9rem;
            color: #333;
            line-height: 1.4;
        }
        .card-details h4 {
            margin-top: 0.5rem;
            color: #005bff;
            font-weight: 600;
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

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .review-container {
                flex-direction: column;
                gap: 2rem;
            }
            .container-left, .container-right {
                flex: 1 1 100%;
                margin: 0 auto;
            }
            .container-right {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
            .nav-links ul {
                display: none; /* Or turn into a mobile nav toggle if needed */
            }
            .navbar .search-bar {
                display: none; /* Hide for smaller screens or build a collapsible menu */
            }
        }
    </style>
</head>
<body>

<!-- Navbar -->
<header class="navbar">
    <div class="container">
        <div class="logo">
            <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Logo">
        </div>
        <div class="search-bar">
            <input type="text" placeholder="Search destinations, agencies, etc."/>
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="#agencies">Agencies</a></li>
                <li><a href="#travel-packages">Travel Packages</a></li>
                <li><a href="#reviews">Reviews</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/signup" class="btn btn-secondary">Sign Up</a>
        </div>
    </div>
</header>

<!-- Hero Section (Swiper Slideshow) -->
<section class="hero-section">
    <div class="swiper-container myHeroSwiper">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide" style="background-image: url('https://via.placeholder.com/1920x800?text=Slide+1');">
                <div class="caption">Explore the world with us</div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide" style="background-image: url('https://via.placeholder.com/1920x800?text=Slide+2');">
                <div class="caption">Your adventure begins here</div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide" style="background-image: url('https://via.placeholder.com/1920x800?text=Slide+3');">
                <div class="caption">Discover new destinations</div>
            </div>
        </div>
        <!-- Swiper Controls -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Featured Agencies (Horizontal Slider) -->
<section class="section-agency" id="agencies">
    <h2>Featured Agency</h2>
    <div class="swiper swiper-agency">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Agency+1" alt="Beach Paradise">
                <div class="agency-content">
                    <h3>Beach Paradise</h3>
                    <p>Relax on the most pristine beaches.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Agency+2" alt="Mountain Retreat">
                <div class="agency-content">
                    <h3>Mountain Retreat</h3>
                    <p>Rejuvenate in the serene mountains.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Agency+3" alt="City Explorer">
                <div class="agency-content">
                    <h3>City Explorer</h3>
                    <p>Discover vibrant cityscapes.</p>
                </div>
            </div>
            <!-- Add more slides as needed -->
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Featured Travel Packages (Horizontal Slider) -->
<section class="section-packages" id="travel-packages">
    <h2>Featured Travel Packages</h2>
    <div class="swiper swiper-packages">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Package+1" alt="Beach Paradise">
                <div class="package-content">
                    <h3>Beach Paradise</h3>
                    <p>Relax on the most pristine beaches.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Package+2" alt="Mountain Retreat">
                <div class="package-content">
                    <h3>Mountain Retreat</h3>
                    <p>Rejuvenate in the serene mountains.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=Package+3" alt="City Explorer">
                <div class="package-content">
                    <h3>City Explorer</h3>
                    <p>Discover vibrant cityscapes.</p>
                </div>
            </div>
            <!-- Add more slides as needed -->
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>

<!-- Reviews -->
<section class="review-container" id="reviews">
    <div class="container-left">
        <h2>Read what our customers love about us</h2>
        <p>Over 200 companies from diverse sectors consult us to enhance the user experience and revenue with our services.</p>
        <p>We have helped companies increase their customer base and generate multiple revenue streams with our expertise.</p>
        <button>Read Our Success Story</button>
    </div>
    <div class="container-right">
        <div class="card">
            <img
                    src="https://cdni.iconscout.com/illustration/premium/thumb/woman-profile-illustration-download-in-svg-png-gif-file-formats--young-female-girl-avatar-portraits-pack-people-illustrations-6590622.png?f=webp"
                    alt="Anna Smith"
            />
            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "Fantastic service and memorable trips! Elite Travel made booking easy and tailored everything to my preferences.
                        Highly recommend for a stress-free vacation!"
                    </p>
                    <h4>- Anna Smith</h4>
                </div>
            </div>
        </div>
        <div class="card">
            <img
                    src="https://st3.depositphotos.com/15648834/17930/v/450/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg"
                    alt="Land Johnson"
            />
            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "User-friendly and efficient! The Elite Travel Agency made booking my trip a breeze. It’s easy to navigate, offers
                        great recommendations, and I love the real-time updates. Highly recommend for hassle-free travel planning!"
                    </p>
                    <h4>- Land Johnson</h4>
                </div>
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
        <p>&copy; <span>2025</span> Elite Travel. All Rights Reserved.</p>
    </div>
</footer>

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- Custom JS -->
<script>
    // Hero Swiper
    const heroSwiper = new Swiper('.myHeroSwiper', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        speed: 800,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });

    // Agencies Swiper
    const agencySwiper = new Swiper('.swiper-agency', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        speed: 600,
        autoplay: {
            delay: 3000,
        },
        navigation: {
            nextEl: '.swiper-agency .swiper-button-next',
            prevEl: '.swiper-agency .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-agency .swiper-pagination',
            clickable: true
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });

    // Packages Swiper
    const packagesSwiper = new Swiper('.swiper-packages', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        speed: 600,
        autoplay: {
            delay: 3500,
        },
        navigation: {
            nextEl: '.swiper-packages .swiper-button-next',
            prevEl: '.swiper-packages .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-packages .swiper-pagination',
            clickable: true
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });
</script>

</body>
</html>
