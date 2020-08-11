<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?php echo isset($app['description']) ? $app['description'] . ' - ' : '' ?>">
    <meta name="author" content="Jonathan Estrella">

    <title><?php echo isset($app['name']) ? $app['name'] . ' - ' : '' ?>SQA Web Tools</title>

    <link rel="preload" href="/resources/css/bundle.css" as="style">
    <link rel="preload" href="/resources/js/main.bundle.js" as="script">
    <?php if ($app['jquery'] ?? false): ?>
        <link rel="preload" href="/resources/js/jquery.bundle.js" as="script">
    <?php endif ?>

    <link rel="icon" href="{{ mix('/static/images/logo.svg') }}" type="image/svg+xml">
    <link rel="alternate icon" href="/resources/icons/<?= $app['logo'] ?>" sizes="32x32" type="image/png">
    <link rel="stylesheet" href="/resources/css/bundle.css" type="text/css">
    <script type="text/javascript" src="/resources/js/main.bundle.js"></script>
    <?php if ($app['jquery'] ?? false): ?>
        <script type="text/javascript" src="/resources/js/jquery.bundle.js"></script>
    <?php endif ?>

    <base href="https://staging.cenpos.com/qatools">
</head>