<?php if (isset($externalScripts)): ?>
    <?php foreach ($externalScripts as $script): ?>
        <script src="<?= $script ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<script src="<?= base_url('/js/app.js') ?>"></script>
<script src="<?= base_url('/js/functions.js') ?>"></script>

<?php if (isset($jsFiles)): ?>
    <?php foreach ($jsFiles as $jsFile): ?>
        <script src="<?= base_url("/js/$jsFile") ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

</body>
</html>