<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

$user = new \App\model\admin\account\User();
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <button type="button" class="btn default pull-right mr-5 mt-3" <?= $user->getRights() >= 4 ? '' : 'disabled' ?>
                    onclick="window.location.href='/admin/project/create'">
                <?= \App\services\core\Translation::get('create_project_button') ?>
            </button>

            <h1 class="pull-left ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle projecten.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                loadTable('projects',['Titel', 'Thumbnail', 'Slideshow', 'Banner', 'Bewerken'], $projects ?? []);
                ?>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>