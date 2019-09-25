<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\services\core\Request;
use App\services\core\Translation;

$request = new Request();
?>

    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <h1 class="ml-5 mt-2"><?= $title ?? '' ?></h1>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Maak hier een nieuw account aan.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');
                $request = new Request();
                ?>

                <form method="post" action="/admin/account/store">
                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="name">
                            <b><?= Translation::get('form_name') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="50"
                                   value="<?= htmlspecialchars_decode($request->post('name')) ?>" required
                                    placeholder="<?= Translation::get('form_name_placeholder') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="email">
                            <b><?= Translation::get('form_email') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="email" id="email" name="email" minlength="2"
                                   value="<?= $request->post('email') ?>" maxlength="100" required
                                   placeholder="<?= Translation::get('form_email_placeholder') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="password">
                            <b><?= Translation::get('form_password') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="password" name="password" minlength="4"
                                   required placeholder="<?= Translation::get('form_password_placeholder') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="confirmationPassword">
                            <b><?= Translation::get('form_confirm_password') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="confirmationPassword"
                                   name="confirmationPassword" minlength="4" required
                                   placeholder="<?= Translation::get('form_confirm_password_placeholder') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="rights">
                            <b><?= Translation::get('form_rights') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <select id="rights" class="form-control" name="rights" required>
                                <option value="" <?= intval($request->post('rights')) === 0 ? 'selected' : 'selected' ?>>
                                    <?= Translation::get('form_rights_placeholder') ?></option>
                                <option value="1" <?= intval($request->post('rights')) === 1 ? 'selected' : '' ?>><?= Translation::get('form_rights_level_1') ?></option>
                                <option value="2" <?= intval($request->post('rights')) === 2 ? 'selected' : '' ?>><?= Translation::get('form_rights_level_2') ?></option>
                                <option value="3" <?= intval($request->post('rights')) === 3 ? 'selected' : '' ?>><?= Translation::get('form_rights_level_3') ?></option>
                                <option value="4" <?= intval($request->post('rights')) === 4 ? 'selected' : '' ?>><?= Translation::get('form_rights_level_4') ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn btn-success" type="button"
                                    onclick="window.location.href='/admin/accounts'">
                                <?= Translation::get('back_button') ?>
                            </button>
                        </div>

                        <div class="col-sm-10">
                            <button class="btn default mr-2" type="submit">
                                <?= Translation::get('save_button') ?>
                            </button>

                            <span style="color: red">
                                <?= Translation::get('form_message_for_required_fields') ?>
                            </span>
                        </div>
                    </div>
                </form>

            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>

</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>