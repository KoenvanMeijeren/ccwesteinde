<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <h1 class="ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>