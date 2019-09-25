<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\services\core\Translation;

?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <div class="mr-5 mt-2 pull-right">
                <button class="btn btn-success" onclick="window.location.href='/admin/user/account'">
                    <?= Translation::get('account_maintenance_button') ?>
                </button>
                <button class="btn default" onclick="window.location.href='/admin/account/create'">
                    <?= Translation::get('add_account_button') ?>
                </button>
            </div>
            <div class="ml-5 mt-3 pull-left">
                <h1><?= $title ?? '' ?></h1>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle accounts. Accounts kunnen bewerkt, gedeblokkeerd of verwijderd worden.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                loadTable(
                    'account',
                    [
                        Translation::get('table_row_name'),
                        Translation::get('table_row_email'),
                        Translation::get('table_row_rights'),
                        Translation::get('table_row_block'),
                        Translation::get('table_row_edit')
                    ],
                    $accounts ?? []
                );
                ?>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>