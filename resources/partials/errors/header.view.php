<?php

use App\services\core\Config;
use App\services\Settings;

$settings = new \App\model\admin\settings\Settings();
?>
<!DOCTYPE HTML>
<html lang="<?= Config::get('languageCode') ?>">
<head>
    <!-- Favicon -->
    <link rel="icon" href="/resources/assets/images/faviconCC.png" type="image/png" sizes="16x16">

    <!-- Title -->
    <title><?= $title ?? '' ?> - <?= $settings->get('companyName') ?></title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8">

    <!-- Fonts -->
    <link href="/resources/assets/fonts/AauxRegularBold.ttf" rel="stylesheet">

    <!-- Stylesheets -->
    <link href="/resources/assets/plugin-frameworks/bootstrap.min.css" rel="stylesheet">
    <link href="/resources/assets/plugin-frameworks/swiper.css" rel="stylesheet">

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</head>
<body>