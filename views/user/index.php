<?php
$title = 'Elite Travel | Home';
$cssFile = 'user/index.css?=v' . time();
require_once app_path('includes/layout-header.php');
?>
<link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet"
/>

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

<!-- Slideshow -->
<div class="slideshow-container">
    <div class="slide active" style="background-image: url('https://via.placeholder.com/1920x600?text=Slide+1');">
        <div class="caption">Explore the world with us</div>
    </div>
    <div class="slide" style="background-image: url('https://via.placeholder.com/1920x600?text=Slide+2');">
        <div class="caption">Your adventure begins here</div>
    </div>
    <div class="slide" style="background-image: url('https://via.placeholder.com/1920x600?text=Slide+3');">
        <div class="caption">Discover new destinations</div>
    </div>
    <button class="prev">&#10094;</button>
    <button class="next">&#10095;</button>
    <div class="dots">
        <span class="dot active" data-slide="0"></span>
        <span class="dot" data-slide="1"></span>
        <span class="dot" data-slide="2"></span>
    </div>
</div>

<!-- Travel Packages Section -->
<section class="travel-packages2">
    <div class="container2">
        <h2>Featured Agency</h2>
        <div class="card-container2">
            <div class="card2">
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
<div class="review-conteiner">

    <div class="container-left">
        <h2>Read what our costumer love about us</h2>
        <p>
            Over 200 companies firm diverse sectors consult us to enhance the user experience revenue with our services.
        </p>
        <p>
            We have helped companies increase their costumers base and generate multiple revenue with our services.
        </p>
        <button>Read our succes story</button>
    </div>

    <div class="container-right">
        <div class="card">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/woman-profile-illustration-download-in-svg-png-gif-file-formats--young-female-girl-avatar-portraits-pack-people-illustrations-6590622.png?f=webp">
            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "Fantastic service and memorable trips!"
                        Elite Travel made booking easy and tailored everything to my preferences. Highly recommend for a
                        stress-free vacation!


                    </p>
                    <h4>
                        -Anna Smith
                    </h4>

                </div>
            </div>
        </div>
        <div class="card">
            <img src="https://st3.depositphotos.com/15648834/17930/v/450/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg">

            <div class="card-content">
                <span><i class="ri-double-quotes-l"></i></span>
                <div class="card-details">
                    <p>
                        "User-friendly and efficient!"
                        The Elite Travel Agency made booking my trip a breeze. It’s easy to navigate, offers great
                        recommendations, and I love the real-time updates. Highly recommend for hassle-free travel
                        planning!


                    </p>
                    <h4>
                        -Land Johnson
                    </h4>

                </div>
            </div>
        </div>
    </div>
</div>
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

        <!-- JavaScript for Slideshow -->
        <script>
            let currentSlide = 0;
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.dot');

            function showSlide(index) {
                slides.forEach((slide, i) => {
                    slide.classList.toggle('active', i === index);
                });
                dots.forEach((dot, i) => {
                    dot.classList.toggle('active', i === index);
                });
                currentSlide = index;
            }

            document.querySelector('.next').addEventListener('click', () => {
                const nextSlide = (currentSlide + 1) % slides.length;
                showSlide(nextSlide);
            });

            document.querySelector('.prev').addEventListener('click', () => {
                const prevSlide = (currentSlide - 1 + slides.length) % slides.length;
                showSlide(prevSlide);
            });

            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    const index = parseInt(e.target.dataset.slide, 10);
                    showSlide(index);
                });
            });

            // Auto-slide every 5 seconds
            setInterval(() => {
                const nextSlide = (currentSlide + 1) % slides.length;
                showSlide(nextSlide);
            }, 5000);
        </script>

        <!-- CSS f<or Slideshow -->


