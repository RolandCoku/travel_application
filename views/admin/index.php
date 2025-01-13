<?php
$cssFile = '/admin/adminDashboard.css';
require_once app_path('includes/layout-header.php'); ?>
<link
href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet"
/>


<div class="container">
    <!-- Sidebar -->
    <aside>
        <div class="top">
            <div class="logo">
                <h2>TRAVEL<span class="danger">ADMIN</span></h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp"> close </span>
            </div>
        </div>

        <div class="sidebar">
            <a href="#" class="active">
                <span class="material-icons-sharp"> dashboard </span>
                <h3>Dashboard</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> flight </span>
                <h3>Bookings</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> location_on </span>
                <h3>Destinations</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> query_stats </span>
                <h3>Analytics</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> mail_outline </span>
                <h3>Inquiries</h3>
                <span class="message-count">12</span>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> feedback </span>
                <h3>Feedback</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> inventory </span>
                <h3>Packages</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> settings </span>
                <h3>Settings</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> add </span>
                <h3>Add Destination</h3>
            </a>
            <a href="#">
                <span class="material-icons-sharp"> logout </span>
                <h3>Logout</h3>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main>
        <div class="header">
            <h1>Travel Dashboard</h1>
            <div class="date">
                <input type="date" />
            </div>
        </div>

        <div class="insights">
            <div class="bookings">
                <span class="material-icons-sharp"> flight </span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Bookings</h3>
                        <h1>1,245</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx="38" cy="38" r="36"></circle>
                        </svg>
                        <div class="number">
                            <p>78%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted"> Last 7 days </small>
            </div>

            <div class="expenses">
                <span class="material-icons-sharp"> bar_chart </span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Expenses</h3>
                        <h1>$18,540</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx="38" cy="38" r="36"></circle>
                        </svg>
                        <div class="number">
                            <p>65%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted"> Last 7 days </small>
            </div>

            <div class="new-users">
                <span class="material-icons-sharp"> group </span>
                <div class="middle">
                    <div class="left">
                        <h3>New Users</h3>
                        <h1>432</h1>
                    </div>
                    <div class="progress">
                        <svg>
                            <circle cx="38" cy="38" r="36"></circle>
                        </svg>
                        <div class="number">
                            <p>56%</p>
                        </div>
                    </div>
                </div>
                <small class="text-muted"> Last 7 days </small>
            </div>
        </div>

        <!-- Recent Bookings -->
        <div class="recent-orders">
            <h2>Recent Bookings</h2>
            <table>
                <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Destination</th>
                    <th>Booking Date</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Jane Doe</td>
                    <td>Paris</td>
                    <td>2025-01-10</td>
                    <td><span class="success">Confirmed</span></td>
                    <td class="primary">Details</td>
                </tr>
                <tr>
                    <td>John Smith</td>
                    <td>New York</td>
                    <td>2025-01-12</td>
                    <td><span class="warning">Pending</span></td>
                    <td class="primary">Details</td>
                </tr>
                </tbody>
            </table>
            <a href="#">View All Bookings</a>
        </div>
    </main>

    <!-- Right Sidebar -->
    <div class="right">
        <div class="top">
            <button id="menu-btn">
                <span class="material-icons-sharp"> menu </span>
            </button>
            <div class="theme-toggler">
                <span class="material-icons-sharp active"> light_mode </span>
                <span class="material-icons-sharp"> dark_mode </span>
            </div>
            <div class="profile">
                <div class="info">
                    <p>Hello, <b>Admin</b></p>
                    <small class="text-muted">Travel Manager</small>
                </div>
                <div class="profile-photo">
                    <img src="person2.png" alt="Profile Picture" />
                </div>
            </div>
        </div>

        <div class="recent-updates">
            <h2>Latest Updates</h2>
            <div class="update">
                <p><b>John Smith</b> just booked a trip to New York.</p>
                <small class="text-muted">2 minutes ago</small>
            </div>
            <div class="update">
                <p><b>Jane Doe</b> left a 5-star review for Paris package.</p>
                <small class="text-muted">1 hour ago</small>
            </div>
        </div>

        <div class="sales-analytics">
            <h2>Top Destinations</h2>
            <div class="item">
                <div>
                    <h3>Paris</h3>
                    <p>250 bookings</p>
                </div>
            </div>
            <div class="item">
                <div>
                    <h3>Bali</h3>
                    <p>200 bookings</p>
                </div>
            </div>
            <div class="item">
                <div>
                    <h3>New York</h3>
                    <p>180 bookings</p>
                </div>
            </div>
            <div class="item add-destination">
                <span class="material-icons-sharp"> add </span>
                <h3>Add Destination</h3>
            </div>
        </div>
    </div>
</div>
<script src="js/adminDashboard.js"></script>
<?php require_once app_path('includes/layout-footer.php'); ?>



