<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Elite Travel | Packages (Multi-Row)</title>

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
          Color palette & gradient references from previous pages:
          Primary colors: #2891ff, #005bff
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
          HERO / BANNER SECTION
          ========================================
        */
        .packages-hero {
            width: 100%;
            height: 50vh;
            margin-top: 76px; /* to offset navbar height */
            background: url('https://via.placeholder.com/1920x600?text=Travel+Packages') no-repeat center center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .packages-hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
        }
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            color: #fff;
            max-width: 600px;
        }
        .hero-content h1 {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
        }
        .hero-content p {
            font-size: 1.2rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
        }

        /*
          ========================================
          PACKAGES SECTION
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
            text-align: center;
        }
        .swiper {
            position: relative;
        }
        .swiper .swiper-wrapper {
            /*
              If you notice large gaps, you can reduce padding here
            */
            padding-bottom: 3rem;
        }
        .swiper .swiper-slide {
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
        .swiper .swiper-slide:hover {
            transform: translateY(-5px);
        }
        .swiper .swiper-slide img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .swiper .content {
            padding: 1rem;
            text-align: center;
        }
        .swiper .content h3 {
            margin: 0.5rem 0;
            color: #005bff;
            font-size: 1.2rem;
        }
        .swiper .content p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.4;
        }
        .swiper .swiper-button-next,
        .swiper .swiper-button-prev {
            color: #2891ff;
            transition: color 0.3s ease;
        }
        .swiper .swiper-button-next:hover,
        .swiper .swiper-button-prev:hover {
            color: #005bff;
        }
        .swiper .swiper-pagination-bullet {
            background: #2891ff;
            opacity: 0.7;
        }
        .swiper .swiper-pagination-bullet-active {
            background: #005bff;
            opacity: 1;
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

        /*Book now button */

        .content .btn {
            text-align: center;
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #ffffff;
        }
        .content .btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #2891ff, #005bff);
        }

        .content p{
            margin-bottom: 1rem;
        }
        .location-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 10px 0;
            color: #333;
            font-size: 16px;
        }

        .swiper-slide .content .location-container .price {
            color: #2891ff; /* Ensure direct targeting */
            margin-left: auto;
            font-size: 1rem;
            font-weight: bold;
        }

        .location-icon {
            font-size: 20px; /* Adjust icon size */
            color: #2891ff; /* Icon color */
            margin-top: -18px;
            align-items: center;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .nav-links ul {
                display: none; /* Or turn into a mobile nav toggle if needed */
            }
            .navbar .search-bar {
                display: none; /* Hide for smaller screens or build a collapsible menu */
            }
            .packages-hero {
                height: 40vh;
            }
            .hero-content h1 {
                font-size: 2rem;
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
            <input type="text" placeholder="Search packages..."/>
        </div>
        <nav class="nav-links">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="#by-agency">By Agency</a></li>
                <li><a href="#most-liked">Most Liked</a></li>
                <li><a href="#new-packages">New Packages</a></li>
            </ul>
        </nav>
        <div class="user-actions">
            <a href="/login" class="btn btn-primary">Login</a>
            <a href="/signup" class="btn btn-secondary">Sign Up</a>
        </div>
    </div>
</header>

<!-- Hero / Banner -->
<section class="packages-hero">
    <div class="hero-content">
        <h1>Discover Our Amazing Packages</h1>
        <p>Multiple categories and multiple rows of your favorite travel deals!</p>
    </div>
</section>

<!-- Packages by Agency (Multi-row) -->
<section class="section-packages" id="by-agency">
    <h2>Travel Packages by Agency</h2>
    <div class="swiper swiper-agency">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyA+1" alt="Agency A Package 1">
                <div class="content">
                    <h3>Beach Escape</h3>
                    <p>Relax at a seaside resort with Agency A.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price"> Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyA+2" alt="Agency A Package 2">
                <div class="content">
                    <h3>Tropical Paradise</h3>
                    <p>Discover lush rainforests and clear waters.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price">Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyB+1" alt="Agency B Package 1">
                <div class="content">
                    <h3>City Adventures</h3>
                    <p>Explore a vibrant city with Agency B.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price">Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyB+2" alt="Agency B Package 2">
                <div class="content">
                    <h3>Mountain Trails</h3>
                    <p>Experience thrilling hikes and breathtaking views.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price">Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
                </div>
            </div>
            <!-- Slide 5 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyC+1" alt="Agency C Package 1">
                <div class="content">
                    <h3>Safari Tour</h3>
                    <p>Spot wildlife in their natural habitat.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price">Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
                </div>
            </div>
            <!-- Slide 6 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=AgencyC+2" alt="Agency C Package 2">
                <div class="content">
                    <h3>Cultural Immersion</h3>
                    <p>Dive into local traditions and cuisine.</p>
                    <div class="location-container">
                        <span class="location-icon ri-map-pin-line"></span>
                        <p>Your location text here</p>
                        <p class="price">Price</p>
                    </div>
                    <a href="#" class="btn"> Book now</a>
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

<!-- Most Liked Packages (Multi-row) -->
<section class="section-packages" id="most-liked">
    <h2>Most Liked Packages</h2>
    <div class="swiper swiper-most-liked">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+1" alt="Most Liked 1">
                <div class="content">
                    <h3>Romantic Getaway</h3>
                    <p>Ideal for couples seeking a dreamy vacation.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+2" alt="Most Liked 2">
                <div class="content">
                    <h3>Family Fun</h3>
                    <p>Activities for all ages, popular among families.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+3" alt="Most Liked 3">
                <div class="content">
                    <h3>Safari Adventure</h3>
                    <p>Spot wildlife and enjoy scenic landscapes.</p>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+4" alt="Most Liked 4">
                <div class="content">
                    <h3>Cultural Tour</h3>
                    <p>Immerse yourself in local arts and traditions.</p>
                </div>
            </div>
            <!-- Slide 5 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+5" alt="Most Liked 5">
                <div class="content">
                    <h3>Island Hopping</h3>
                    <p>Visit multiple tropical islands in one trip.</p>
                </div>
            </div>
            <!-- Slide 6 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=MostLiked+6" alt="Most Liked 6">
                <div class="content">
                    <h3>Nature Retreat</h3>
                    <p>Unwind in pristine environments.</p>
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

<!-- New Packages (Multi-row) -->
<section class="section-packages" id="new-packages">
    <h2>New Packages</h2>
    <div class="swiper swiper-new-packages">
        <div class="swiper-wrapper">
            <!-- Slide 1 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+1" alt="New Package 1">
                <div class="content">
                    <h3>Island Hopping</h3>
                    <p>Discover newly added island tours.</p>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+2" alt="New Package 2">
                <div class="content">
                    <h3>Winter Wonderland</h3>
                    <p>See our newly introduced snowy lodges.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+3" alt="New Package 3">
                <div class="content">
                    <h3>Desert Exploration</h3>
                    <p>Ride across dunes in a new adventurous route.</p>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+4" alt="New Package 4">
                <div class="content">
                    <h3>Hidden Gem Tour</h3>
                    <p>Explore fresh undiscovered scenic spots.</p>
                </div>
            </div>
            <!-- Slide 5 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+5" alt="New Package 5">
                <div class="content">
                    <h3>Historic Trails</h3>
                    <p>Visit heritage sites on our latest walking tours.</p>
                </div>
            </div>
            <!-- Slide 6 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+6" alt="New Package 6">
                <div class="content">
                    <h3>Waterfall Escapes</h3>
                    <p>Brand new waterfalls in our curated itineraries.</p>
                </div>
            </div>


            <!-- Slide 2 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+2" alt="New Package 2">
                <div class="content">
                    <h3>Winter Wonderland</h3>
                    <p>See our newly introduced snowy lodges.</p>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+3" alt="New Package 3">
                <div class="content">
                    <h3>Desert Exploration</h3>
                    <p>Ride across dunes in a new adventurous route.</p>
                </div>
            </div>
            <!-- Slide 4 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+4" alt="New Package 4">
                <div class="content">
                    <h3>Hidden Gem Tour</h3>
                    <p>Explore fresh undiscovered scenic spots.</p>
                </div>
            </div>
            <!-- Slide 5 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+5" alt="New Package 5">
                <div class="content">
                    <h3>Historic Trails</h3>
                    <p>Visit heritage sites on our latest walking tours.</p>
                </div>
            </div>
            <!-- Slide 6 -->
            <div class="swiper-slide">
                <img src="https://via.placeholder.com/300x200?text=NewPackage+6" alt="New Package 6">
                <div class="content">
                    <h3>Waterfall Escapes</h3>
                    <p>Brand new waterfalls in our curated itineraries.</p>
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
    // Packages by Agency Swiper (multi-row)
    const agencySwiper = new Swiper('.swiper-agency', {
        // IMPORTANT: disable loop to avoid blank slides if not enough slides
        loop: false,
        speed: 600,
        grid: {
            rows: 2,             // number of rows
            fill: 'row',         // fill by row
        },
        slidesPerView: 3,      // 3 columns
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-agency .swiper-button-next',
            prevEl: '.swiper-agency .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-agency .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        }
    });

    // Most Liked Packages Swiper (multi-row)
    const mostLikedSwiper = new Swiper('.swiper-most-liked', {
        loop: false,
        speed: 600,
        grid: {
            rows: 2,
            fill: 'row',
        },
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-most-liked .swiper-button-next',
            prevEl: '.swiper-most-liked .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-most-liked .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        }
    });

    // New Packages Swiper (multi-row)
    const newPackagesSwiper = new Swiper('.swiper-new-packages', {
        loop: false,
        speed: 600,
        grid: {
            rows: 2,
            fill: 'row',
        },
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-new-packages .swiper-button-next',
            prevEl: '.swiper-new-packages .swiper-button-prev',
        },
        pagination: {
            el: '.swiper-new-packages .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            300: {
                slidesPerView: 1,
                spaceBetween: 10,
                grid: {
                    rows: 2,
                },
            },
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                grid: {
                    rows: 2,
                },
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 30,
                grid: {
                    rows: 2,
                },
            },
        }
    });
</script>

</body>
</html>

<!--
Grid Layout

The Swiper option grid: { rows: 2, fill: 'row' } and slidesPerView: 3 produce 2 rows × 3 columns per “page” of the carousel, i.e., 6 cards visible at once.
You can tweak this for each category (maybe 2 rows for “By Agency” and 1 row for “New Packages,” etc.) by adjusting grid.rows and slidesPerView.
Loop vs. Non-Loop

We set loop: false to avoid blank slides if you don’t have enough slides to fill all grid spots in every loop iteration. If you do want looping, ensure you have multiples of the total grid cells. For a 2×3 grid, you’d need at least 6, 12, 18, etc. slides to avoid empty space.
Responsive Breakpoints

Shown above with breakpoints at 300px, 576px, 992px.
For small screens, we switch to slidesPerView: 1, grid: { rows: 2 } to keep it looking good on mobile. Adjust as needed.
Styling

The rest of the page (navbar, hero, footer) follows the same color palette, glass-like touches, and layout from the previous examples for consistency.
-->