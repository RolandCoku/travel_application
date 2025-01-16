<script src="<?= base_url('/js/functions.js') ?>"></script>
<script src="<?= base_url('/js/app.js') ?>"></script>
<?php if (isset($jsFiles)): ?>
    <?php foreach ($jsFiles as $jsFile): ?>
        <script src="<?= base_url("/js/$jsFile") ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>