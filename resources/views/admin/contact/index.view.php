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
            <h1 class="ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Overzicht van alle contact personen. De contactpersonen worden gebruikt in het contactformulier.
                    <br>
                    Bedrijven kunnen per persoon contact opnemen.
                    De contactpersonen worden als volgt getoond: <b>werkveld (landschap) - naam</b>
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                $button = \App\services\core\Translation::get('add_button');
                $action = '/admin/contact/store';
                if (isset($contact) && !empty($contact)) {
                    $button = \App\services\core\Translation::get('save_button');
                    $action = '/admin/contact/' . ($contact->contact_ID ?? 0) . '/update';
                }
                ?>

                <form method="post" action="<?= $action ?>">
                    <?= \App\services\security\CSRF::formToken($action) ?>

                    <div class="row form-group">
                        <label class="col-sm-1" for="name">
                            <b><?= Translation::get('form_name') ?></b><span style="color: red">*</span>
                        </label>

                        <div class="col-sm-2">
                            <input type="text" id="name" name="name" class="ml-1 mr-1 form-control" minlength="2"
                                   maxlength="255" required
                                   placeholder="<?= Translation::get('form_name_placeholder') ?>"
                                   value="<?= !empty($request->post('name')) ?
                                       htmlspecialchars_decode($request->post('name')) :
                                       htmlspecialchars_decode($contact->contact_name ?? '') ?>">
                        </div>

                        <label class="col-sm-1" for="email">
                            <b><?= Translation::get('form_email') ?></b><span style="color: red">*</span>
                        </label>

                        <div class="col-sm-2">
                            <input class="form-control mr-1" id="email" name="email" type="text" required minlength="2"
                                   placeholder="<?= Translation::get('form_email_placeholder') ?>" maxlength="255"
                                   value="<?= !empty($request->post('email')) ? $request->post('email') :
                                       $contact->contact_email ?? '' ?>">
                        </div>

                        <label class="col-sm-1" for="branch">
                            <b><?= Translation::get('form_branch') ?></b><span style="color: red">*</span>
                        </label>

                        <div class="col-sm-2">
                            <select id="branch" name="branchID" class="mr-1 form-control">
                                <option value=""><?= Translation::get('form_choose_branch') ?></option>
                                <?php if (isset($branches) && !empty($branches) && is_array($branches)) :
                                    foreach ($branches as $branch) : ?>
                                        <option value="<?= $branch->entity_ID ?? 0 ?>"
                                            <?= !empty(intval($contact->contact_branch_ID ?? 0)) &&
                                            intval($contact->contact_branch_ID ?? 0) === intval($branch->entity_ID ?? 0) ?
                                                'selected' : '' ?>>
                                            <?= htmlspecialchars_decode($branch->entity_name ?? '') ?>
                                        </option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <label class="col-sm-1" for="landscape">
                            <b><?= Translation::get('form_landscape') ?></b><span style="color: red">*</span>
                        </label>

                        <div class="col-sm-2">
                            <select id="landscape" name="landscapeID" class="mr-1 form-control">
                                <option value=""><?= Translation::get('form_choose_landscape') ?></option>
                                <?php if (isset($landscapes) && !empty($landscapes) && is_array($landscapes)) :
                                    foreach ($landscapes as $landscape) : ?>
                                        <option value="<?= $landscape->entity_ID ?? 0 ?>"
                                            <?= !empty(intval($contact->contact_landscape_ID ?? 0)) &&
                                            intval($contact->contact_landscape_ID ?? 0) === intval($landscape->entity_ID ?? 0) ?
                                                'selected' : '' ?>>
                                            <?= htmlspecialchars_decode($landscape->entity_name ?? '') ?>
                                        </option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>

                        <div class="col">
                            <button type="submit"
                                    class="btn default pull-right" <?= $user->getRights() >= 4 ? '' : 'disabled' ?>>
                                <?= $button ?>
                            </button>
                        </div>
                    </div>




            </form>

            <?php
            loadTable('contacts', [
                \App\services\core\Translation::get('table_row_branch'),
                \App\services\core\Translation::get('table_row_landscape'),
                \App\services\core\Translation::get('table_row_name'),
                \App\services\core\Translation::get('table_row_email'),
                \App\services\core\Translation::get('table_row_edit')
            ], $contacts ?? []);
            ?>

        </div>
    </div>
    <!-- END MAIN CONTENT-->
    <!-- END PAGE CONTAINER-->
</div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>