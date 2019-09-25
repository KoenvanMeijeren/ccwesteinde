<?php

use App\model\admin\settings\Settings;
use App\services\core\Config;

$settings = new Settings();
?>
<!DOCTYPE HTML>
<html lang="<?= Config::get('languageCode') ?>">
<head>
    <!-- Required meta tags -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <!-- Favicon -->
    <link rel="icon" href="/resources/assets/images/faviconCC.png" type="image/png" sizes="16x16">

    <!-- Title -->
    <title><?= htmlspecialchars_decode($title ?? '') ?> - <?= $settings->get('companyName') ?></title>

    <!-- Stylesheets -->
    <link href="/resources/assets/plugin-frameworks/bootstrap.min.css" rel="stylesheet">
    <link href="/resources/assets/plugin-frameworks/swiper.css" rel="stylesheet">
    <link href="/resources/assets/admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/plugin-frameworks/fontawesome-free-5.8.2-web/css/all.css" rel="stylesheet">

    <!-- Theme -->
    <link href="/resources/assets/css/theme.css" rel="stylesheet">
    <link href="/resources/assets/css/responsive.css" rel="stylesheet">

    <!-- Bootstrap datepicker -->
    <link href="/resources/assets/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker.standalone.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker3.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker3.standalone.css" rel="stylesheet">

    <!-- Time picker -->
    <link href="/resources/assets/plugin-frameworks/clockpicker-gh-pages/dist/bootstrap-clockpicker.min.css"
          rel="stylesheet">
    <link href="/resources/assets/plugin-frameworks/clockpicker-gh-pages/src/clockpicker.css" rel="stylesheet">

    <?php if (strstr(\App\services\core\URL::getUrl(), 'events') !== false ||
            strstr(\App\services\core\URL::getUrl(), 'event') !== false) : ?>
        <!-- Data tables -->
        <link href="/resources/assets/admin/css/datatables.css" rel="stylesheet" media="all">
        <link href="/resources/assets/admin/css/datatables-select.css" rel="stylesheet" media="all">

        <!-- Cropper JS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.1/cropper.min.css" rel="stylesheet">
    <?php else : ?>
        <link href="/resources/assets/css/special.css" rel="stylesheet" media="all">
    <?php endif; ?>
</head>
<body>

<?php loadFile(RESOURCES_PATH . '/partials/menu.view.php'); ?>
