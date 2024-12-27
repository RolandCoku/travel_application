
<?php require_once app_path('includes/layout-header.php'); ?>

<!-- Only for testing purposes it must be changed" -->

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1>Admin Dashboard</h1>
            <p>Welcome, Admin!</p>
        </div>
    </div>

    <!-- List all the users in a paginated table -->
    <div class="row">
        <div class="col-12">
            <h2>Users</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                if (isset($users)) {
                    foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user['id'] ?></td>
                            <td><?= $user['name'] ?></td>
                            <td><?= $user['email'] ?></td>
                            <td><?= $user['role'] ?></td>
                        </tr>
                    <?php endforeach;
                } ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="col-12">
            <nav aria-label="Page navigation example">
                <ul class="pagination
                    <?php if (isset($page)) {
                    if ($page == 1): ?>
                        pagination-disabled
                    <?php endif;
                } ?>
                ">
                    <li class="page-item">
                        <a class="page-link" href="/admin/dashboard?page=<?= $page - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php if (isset($totalPages)) {
                        for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item
                                <?php if ($i == $page): ?>
                                    active
                                <?php endif; ?>
                            ">
                                <a class="page-link" href="/admin/dashboard?page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor;
                    } ?>
                    <li class="page-item
                        <?php if ($page == $totalPages): ?>
                            pagination-disabled
                        <?php endif; ?>
                    ">
                        <a class="page-link" href="/admin/dashboard?page=<?= $page + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <p>Page <?= $page ?> of <?= $totalPages ?></p>
        </div>
    </div>
</div>

<?php require_once app_path('includes/layout-footer.php'); ?>



