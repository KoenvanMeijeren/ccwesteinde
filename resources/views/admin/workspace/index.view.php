<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\services\core\Translation;

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
                    Overzicht van alle werkplekken en vergaderruimtes. <br>
                    Werkplekken kunnen per dagdeel gereserveerd worden. <br>
                    Vergaderruimtes kunnen variërend van een half uur tot 2 uur gereserveerd worden.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                $button = \App\services\core\Translation::get('add_button');
                $action = '/admin/workspace/store';
                if (isset($workspace) && !empty($workspace)) {
                    $button = \App\services\core\Translation::get('save_button');
                    $action = '/admin/workspace/' . ($workspace->workspace_ID ?? 0) . '/update';
                }
                ?>
                <div class="row">
                    <form class="col-sm-auto form-inline" method="post" action="<?= $action ?>">
                        <?= \App\services\security\CSRF::formToken($action) ?>
                        <div class="form-group">
                            <label for="name"
                                   class="mr-1"><b><?= \App\services\core\Translation::get('form_name') ?></b></label>
                            <input type="text" id="name" name="name" class="form-control mr-1" minlength="2"
                                   maxlength="255" required placeholder="<?= Translation::get('form_name_placeholder') ?>"
                                   value="<?= !empty($request->post('name')) ?
                                       htmlspecialchars_decode($request->post('name')) :
                                       htmlspecialchars_decode($workspace->workspace_name ?? '') ?>">

                            <label class="radio-inline mr-1"><input type="radio" value="0" name="space"
                                    <?= strval($workspace->slug_name ?? '') === 'werkplek' ? 'checked' : 'checked' ?>>
                                <?= Translation::get('form_workspace') ?>
                            </label>
                            <label class="radio-inline mr-1"><input type="radio" value="1" name="space"
                                    <?= strval($workspace->slug_name ?? '') === 'vergaderruimte' ? 'checked' : '' ?>>
                                <?= Translation::get('form_meeting_room') ?>
                            </label>

                            <button type="submit" class="btn default pull-right" <?= $user->getRights() >= 4 ? '' : 'disabled' ?>><?= $button ?></button>
                        </div>
                    </form>
                </div>

                <?php
                loadTable('workspaces', [
                    \App\services\core\Translation::get('table_row_workspace_identifier'),
                    \App\services\core\Translation::get('table_row_name'),
                    \App\services\core\Translation::get('table_row_edit')
                ], $workspaces ?? []);
                ?>

            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>