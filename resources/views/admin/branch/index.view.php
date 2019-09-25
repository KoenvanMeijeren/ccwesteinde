<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

$request = new \App\services\core\Request();
$user = new \App\model\admin\account\User();
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <header class="header-desktop">
            <h1 class="pull-left ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle werkvelden. De werkvelden worden gebruikt bij contactpersonen. <br>
                    De contactpersonen worden als volgt getoond: <b>werkveld (landschap) - naam</b>
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                $button = \App\services\core\Translation::get('add_button');
                $action = '/admin/branch/store';
                if (isset($branch) && !empty($branch)) {
                    $button = \App\services\core\Translation::get('save_button');
                    $action = '/admin/branch/'.($branch->entity_ID ?? 0).'/update';
                }
                ?>

                <form class="form-inline" method="post" action="<?= $action ?>">
                    <?= \App\services\security\CSRF::formToken($action) ?>

                    <div class="form-group">
                        <label for="name">
                            <b><?= \App\services\core\Translation::get('form_name') ?></b><span style="color: red">*</span>
                        </label>
                        <input type="text" id="name" name="name" class="ml-1 mr-1 form-control" minlength="2"
                               maxlength="255" required placeholder="<?= \App\services\core\Translation::get('form_name_placeholder') ?>"
                               value="<?= !empty($request->post('name')) ?
                                   htmlspecialchars_decode($request->post('name')) :
                                   htmlspecialchars_decode($branch->entity_name ?? '') ?>">

                        <button type="submit" class="btn default pull-right" <?= $user->getRights() >= 3 ? '' : 'disabled' ?>><?= $button ?></button>
                    </div>
                </form>

                <?php
                loadTable('branches', [
                    \App\services\core\Translation::get('table_row_name'),
                    \App\services\core\Translation::get('table_row_edit')
                ], $branches ?? []);
                ?>

            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>