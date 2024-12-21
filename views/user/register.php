<?php require_once app_path('includes/layout-header.php'); ?>

<!-- This is only for testing purposes it must be changed to a proper form -->
<body>

    <div class="container">
        <h1>Register</h1>
        <form action="/register" method="post" class="d-flex flex-column gap-3">
            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>
            <!-- SurName -->
            <div class="form-group">
                <label for="surname">Surname</label>
                <input type="text" name="surname" id="surname" class="form-control">
            </div>
            <!-- Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <!-- Confirm Password -->
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control">
            </div>
            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <?php require_once app_path('includes/layout-footer.php'); ?>
