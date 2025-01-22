<?php
global $conn;
if (isset($_SESSION['user_email'])) {
    require_once app_path('models/User.php');
    $userRepo = new User($conn);
    $user = $userRepo->getByEmail($_SESSION['user_email']);
    $profilePicture = $userRepo->profilePicture($user['id']) ?? [];
    $user = [
        'is_logged_in' => true,
        'name' => $user['name'],
        'profile_picture' => $profilePicture['image_url'] ?? 'assets/logo-2.png'
    ];
}
?>

<header class="navbar">
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <a href="/"><img src="<?= base_url('img/assets/full-logo.png') ?>" alt="Logo"></a>
        </div>

        <!-- Search Bar -->
        <!-- <div class="search-bar"> -->
            <form action="/search" class="search-bar" method="GET">
              <label for="travel-search"></label>
                  <input name="travel-search" type="text" placeholder="search ..."/>
            </form>
        <!-- </div> -->

        <!-- Navigation Links -->
        <nav class="nav-links">
            <ul>
                <li><a href="/travel-agencies">agencies</a></li>
                <li><a href="/travel-packages">travel Packages</a></li>
                <li><a href="/about">about us</a></li>
            </ul>
        </nav>

        <!-- User Actions -->
        <div class="user-actions">
            <?php if (isset($user) && $user['is_logged_in']): ?>
                <!-- Profile Dropdown -->
                <div class="profile-dropdown">
                    <div class="profile-wrapper">
                        <img src="<?= base_url('img/' . ($user['profile_picture'] ?? 'default-profile.png')) ?>"
                             alt="Profile Picture"
                             class="profile-picture">
                        <span class="user-name"><?= $user['name'] ?></span>
                    </div>
                    <div class="dropdown-menu">
                        <a href="/account-dashboard">Edit Profile</a>
                        <a href="/logout">Log Out</a>
                    </div>
                </div>
            <?php else: ?>
                <!-- Login/Sign Up Buttons -->
                <a href="/login" class="btn btn-primary">login</a>
                <a href="/register" class="btn btn-secondary">sign up</a>
            <?php endif; ?>
        </div>
    </div>
</header>
