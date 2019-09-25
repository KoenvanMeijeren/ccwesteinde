<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <button type="button" class="btn default pull-right mr-5 mt-3"
                    onclick="window.location.href='/admin/event/create'">
                <?= \App\services\core\Translation::get('create_event_button') ?>
            </button>

            <h1 class="pull-left ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle Meet the Expert sessies.
                    Meet the Expert sessies kunnen bewerkt, gearchiveerd of verwijderd worden.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                loadTable('events',
                    [
                        \App\services\core\Translation::get('table_row_title'),
                        \App\services\core\Translation::get('table_row_thumbnail'),
                        \App\services\core\Translation::get('table_row_banner'),
                        \App\services\core\Translation::get('table_row_datetime'),
                        \App\services\core\Translation::get('table_row_location'),
                        \App\services\core\Translation::get('table_row_maximum_persons'),
                        \App\services\core\Translation::get('table_row_sign_ups'),
                        \App\services\core\Translation::get('table_row_edit')
                    ],
                    $events ?? []
                );
                ?>

                <h3>Gearchiveerde sessies</h3>
                <?php
                loadTable('archivedEvents',
                    [
                        \App\services\core\Translation::get('table_row_title'),
                        \App\services\core\Translation::get('table_row_thumbnail'),
                        \App\services\core\Translation::get('table_row_banner'),
                        \App\services\core\Translation::get('table_row_datetime'),
                        \App\services\core\Translation::get('table_row_location'),
                        \App\services\core\Translation::get('table_row_maximum_persons'),
                        \App\services\core\Translation::get('table_row_sign_ups'),
                        \App\services\core\Translation::get('table_row_edit')
                    ],
                    $archivedEvents ?? []
                );
                ?>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>