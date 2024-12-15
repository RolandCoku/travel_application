<?php require_once app_path('includes/layout-header.php'); ?>

<body>
<div class="container">
    <h1>Login</h1>
    <form action="/login" method="post" class="d-flex flex-column gap-3">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<?php require_once app_path('includes/layout-footer.php'); ?>
