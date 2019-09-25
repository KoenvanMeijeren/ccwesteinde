<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <button type="button" class="btn default pull-right mr-5 mt-3" onclick="window.location.href='/admin/page/create'">
                <?= \App\services\core\Translation::get('create_page_button') ?>
            </button>

            <h1 class="pull-left ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle pagina's. Statische pagina's worden altijd getoond op de website
                    en kan daarom niet worden verwijderd en de url kan niet worden aangepast.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                loadTable('pages',['Url', 'Titel', 'Pagina tonen in menu', 'Bewerken'], $pages ?? [])
                ?>

            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>