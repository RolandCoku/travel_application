<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <title>Elite Travel | Profile</title>
    <style>
        /*
          ========================================
          RESET & GLOBAL STYLES
          ========================================
        */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        html, body {
            width: 100%;
            min-height: 100%;
            background: #f5f9ff; /* consistent with your other pages */
            color: #2b2b2b;
            scroll-behavior: smooth;
        }
        a {
            text-decoration: none;
            color: inherit;
        }
        ul {
            list-style-type: none;
        }

        /*
          ========================================
          NAVBAR (FIXED AT THE TOP)
          ========================================
        */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(4px);
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
            padding: 0.6rem 1.2rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: transform 0.3s, background 0.3s;
            border: none;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #fff;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            background: linear-gradient(135deg, #2891ff, #005bff);
        }
        .btn-secondary {
            background: rgba(255, 255, 255, 0.8);
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
          PROFILE LAYOUT
          ========================================
          A two-column layout:
          - Left: Sidebar (fixed height, full vertical)
          - Right: Main content
        */
        .profile-wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 80px; /* offset for fixed navbar height */
            min-height: calc(100vh - 80px); /* fill vertical space below navbar */
            background: #f5f9ff;
        }

        /*
          ========================================
          SIDEBAR (LEFT)
          ========================================
        */
        .profile-sidebar {
            width: 300px;               /* fixed width for sidebar */
            background: #ffffff;        /* solid background to avoid floating look */
            border-right: 1px solid #eee;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
            width: 100%;
        }
        .profile-avatar {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 0.8rem;
            border: 3px solid #2891ff;
        }
        .profile-header h2 {
            font-size: 1.2rem;
            color: #005bff;
            margin-bottom: 0.2rem;
        }
        .profile-header p {
            font-size: 0.9rem;
            color: #555;
        }

        /* Sidebar menu items */
        .profile-menu {
            width: 100%;
        }
        .profile-menu ul {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }
        .profile-menu li {
            width: 100%;
            padding: 0.8rem 1rem;
            border-radius: 6px;
            cursor: pointer;
            color: #2891ff;
            font-weight: 500;
            transition: background 0.3s, color 0.3s;
        }
        .profile-menu li:hover {
            background: #2891ff;
            color: #fff;
        }
        .profile-menu li.active {
            background: linear-gradient(135deg, #005bff, #2891ff);
            color: #fff;
        }

        /*
          ========================================
          MAIN CONTENT (RIGHT)
          ========================================
        */
        .profile-content {
            flex: 1;               /* take remaining horizontal space */
            padding: 2rem 1.5rem;
        }
        .profile-section {
            display: none;         /* hidden by default */
        }
        .profile-section.active {
            display: block;        /* visible if active */
        }
        .profile-section h1 {
            font-size: 1.6rem;
            color: #005bff;
            margin-bottom: 1rem;
        }
        .profile-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        .profile-card p {
            margin-bottom: 0.8rem;
            color: #333;
            line-height: 1.4;
        }
        .profile-card strong {
            color: #005bff;
        }

        /*
          ========================================
          RESPONSIVE
          ========================================
        */
        @media (max-width: 900px) {
            /*
              Hide desktop nav or convert to hamburger
              if needed (omitted for brevity).
            */
            .nav-links ul, .user-actions {
                display: none;
            }

            .profile-wrapper {
                flex-direction: column;
                margin-top: 60px;
                min-height: auto;
            }

            .profile-sidebar {
                width: 100%;
                flex-direction: row;
                border-right: none;
                border-bottom: 1px solid #eee;
                padding: 1rem;
                overflow-x: auto; /* allow horizontal scroll if needed */
                justify-content: start;
                align-items: flex-start;
            }
            .profile-header {
                display: none; /* hide user avatar & name for mobile if desired */
            }
            .profile-menu ul {
                flex-direction: row;
                gap: 1rem;
                width: auto;
            }
            .profile-menu li {
                flex: 0 0 auto;
                min-width: 100px;
            }
            .profile-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<!-- FIXED NAVBAR -->
<header class="navbar">
    <div class="container">
        <div class="logo">
            <img src="https://via.placeholder.com/150x50?text=Elite+Travel" alt="Elite Travel">
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

<!-- PROFILE WRAPPER (SIDEBAR + CONTENT) -->
<div class="profile-wrapper">

    <!-- LEFT SIDEBAR -->
    <aside class="profile-sidebar">
        <div class="profile-header">
            <img
                    src="https://via.placeholder.com/90?text=User"
                    alt="User Avatar"
                    class="profile-avatar"
            >
            <h2>John Doe</h2>
            <p>johndoe@example.com</p>
        </div>
        <nav class="profile-menu">
            <ul>
                <li data-section="info" class="active">Personal Info</li>
                <li data-section="bookings">Bookings</li>
                <li data-section="reviews">Reviews</li>
                <li data-section="settings">Settings</li>
            </ul>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="profile-content">
        <!-- Personal Info Section -->
        <section id="info" class="profile-section active">
            <h1>Personal Info</h1>
            <div class="profile-card">
                <p><strong>Name:</strong> John Doe</p>
                <p><strong>Email:</strong> johndoe@example.com</p>
                <p><strong>Phone:</strong> +123 456 789</p>
            </div>
        </section>

        <!-- Bookings Section -->
        <section id="bookings" class="profile-section">
            <h1>Your Bookings</h1>
            <div class="profile-card">
                <p>You currently have no bookings.</p>
            </div>
        </section>

        <!-- Reviews Section -->
        <section id="reviews" class="profile-section">
            <h1>Your Reviews</h1>
            <div class="profile-card">
                <p>You haven't written any reviews yet.</p>
            </div>
        </section>

        <!-- Settings Section -->
        <section id="settings" class="profile-section">
            <h1>Account Settings</h1>
            <div class="profile-card">
                <p>Update your account details or password here.</p>
            </div>
        </section>
    </main>
</div>

<!-- JS to Switch Active Sections -->
<script>
    document.querySelectorAll('.profile-menu li').forEach(menuItem => {
        menuItem.addEventListener('click', () => {
            // 1) Deselect previously active menu
            const activeMenu = document.querySelector('.profile-menu li.active');
            if (activeMenu) activeMenu.classList.remove('active');

            // 2) Mark clicked menu as active
            menuItem.classList.add('active');

            // 3) Hide the currently displayed section
            const activeSection = document.querySelector('.profile-section.active');
            if (activeSection) activeSection.classList.remove('active');

            // 4) Show the new section
            const targetId = menuItem.getAttribute('data-section');
            const targetSection = document.getElementById(targetId);
            if (targetSection) targetSection.classList.add('active');
        });
    });
</script>

</body>
</html>
