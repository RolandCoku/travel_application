<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= base_url("/css/style.css?v=" . time()); ?>">

    <?php if (isset($links)): ?>
        <?php foreach ($links as $link): ?>
            <link rel="stylesheet" href="<?= $link ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- TODO: REMOVE THIS LATER TO LEAVE ONLY THE ARRAY -->
    <?php if (isset($cssFile)): ?>
        <link rel="stylesheet" href="<?= base_url("/css/$cssFile"); ?>">
    <?php endif; ?>

    <?php if (isset($cssFiles)): ?>
        <?php foreach ($cssFiles as $cssFile): ?>
            <link rel="stylesheet" href="<?= base_url("/css/$cssFile"); ?>">
        <?php endforeach; ?>
    <?php endif; ?>

    <link href="<?= base_url("/css/boxicons-2.1.4/css/boxicons.min.css"); ?>" rel="stylesheet">
    <title><?= $title = $title ?? 'Elite Travel'?></title>
</head>
