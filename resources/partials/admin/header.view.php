<?php

use App\services\core\Config;

?>
<!DOCTYPE html>
<html lang="<?= Config::get('languageCode') ?>">
<head>
    <!-- Favicon -->
    <link rel="icon" href="/resources/assets/images/faviconCC.png" type="image/png" sizes="16x16">

    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title Page-->
    <title><?= $title ?? '' ?> - CMS</title>

    <!-- Fontfaces CSS-->
    <link href="/resources/assets/admin/css/font-face.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet"
          media="all">
    <link href="/resources/assets/admin/vendor/font-awesome-5.7.2/css/all.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="/resources/assets/admin/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Vendor CSS-->
    <link href="/resources/assets/admin/vendor/animsition/animsition.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/bootstrap-progressbar/bootstrap-progressbar-3.3.4.min.css"
          rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/wow/animate.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/css-hamburgers/hamburgers.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/slick/slick.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/vendor/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="/resources/assets/admin/css/theme.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/css/datatables.css" rel="stylesheet" media="all">
    <link href="/resources/assets/admin/css/datatables-select.css" rel="stylesheet" media="all">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css" rel="stylesheet" media="all">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.semanticui.min.css" rel="stylesheet" media="all">

    <!-- Custom CSS -->
    <link href="/resources/assets/admin/css/style.css" rel="stylesheet" media="all">

    <!-- Bootstrap datepicker -->
    <link href="/resources/assets/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker.standalone.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker3.css" rel="stylesheet">
    <link href="/resources/assets/css/bootstrap-datepicker3.standalone.css" rel="stylesheet">

    <!-- Time picker -->
    <link href="/resources/assets/plugin-frameworks/clockpicker-gh-pages/dist/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="/resources/assets/plugin-frameworks/clockpicker-gh-pages/src/clockpicker.css" rel="stylesheet">

    <!-- Cropper JS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.1/cropper.min.css" rel="stylesheet">
</head>