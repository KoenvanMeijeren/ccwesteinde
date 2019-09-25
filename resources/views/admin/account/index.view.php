<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\models\admin\AdminAccount;
use App\services\core\Translation;

?>
    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <?php
            // only accessible if you are a super admin
            if (($rights ?? 0) >= 4) : ?>
                <div class="mr-5 mt-2 pull-right">
                    <button class="btn default" onclick="window.location.href='/admin/accounts'">
                        <?= Translation::get('accounts_maintenance_button') ?>
                    </button>
                </div>
            <?php endif; ?>

            <div class="ml-5 mt-3 pull-left">
                <h1><?= $title ?? '' ?></h1>
            </div>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5 mb-3">
                <p>
                    Bewerk hier je account. Wachtwoord aanpassen is optioneel.
                </p>
            </div>

            <div class="ml-5 mr-5">
                <form method="post" action="/admin/user/account/<?= $account->account_ID ?? 0 ?>/update">
                    <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                    <?= \App\services\security\CSRF::formToken(
                            '/admin/user/account/' . ($account->account_ID ?? 0) . '/update') ?>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="name">
                            <b><?= Translation::get('form_name') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="text" id="name" name="name" minlength="2" maxlength="100"
                                   value="<?= htmlspecialchars_decode($account->account_name ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="email">
                            <b><?= Translation::get('form_email') ?></b>
                            <span style="color: red">*</span>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="email" id="email" minlength="2"
                                   maxlength="100" value="<?= $account->account_email ?? '' ?>" disabled>
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="currentPassword">
                            <b><?= Translation::get('form_current_password') ?></b>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="currentPassword" name="currentPassword"
                                   minlength="4"
                                   placeholder="<?= Translation::get('form_current_password') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="password">
                            <b><?= Translation::get('form_new_password') ?></b>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="password" name="password"
                                   minlength="4"
                                   placeholder="<?= Translation::get('form_new_password') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="confirmPassword">
                            <b><?= Translation::get('form_confirm_password') ?></b>
                        </label>

                        <div class="col-sm-10">
                            <input class="form-control" type="password" id="confirmPassword" name="confirmPassword"
                                   minlength="4"
                                   placeholder="<?= Translation::get('form_confirm_password') ?>">
                        </div>
                    </div>

                    <div class="row pb-2">
                        <label class="col-sm-2 col-form-label" for="rights">
                            <b><?= Translation::get('form_rights') ?></b>
                        </label>

                        <div class="col-sm-10">
                            <select id="rights" class="form-control" disabled>
                                <option value="1" <?= intval($account->account_rights ?? 0) === 1 ? 'selected' : '' ?>>
                                    <?= Translation::get('form_rights_level_1') ?>
                                </option>
                                <option value="2" <?= intval($account->account_rights ?? 0) === 2 ? 'selected' : '' ?>>
                                    <?= Translation::get('form_rights_level_2') ?>
                                </option>
                                <option value="3" <?= intval($account->account_rights ?? 0) === 3 ? 'selected' : '' ?>>
                                    <?= Translation::get('form_rights_level_3') ?>
                                </option>
                                <option value="4" <?= intval($account->account_rights ?? 0) === 4 ? 'selected' : '' ?>>
                                    <?= Translation::get('form_rights_level_4') ?>
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            <button class="btn default" type="submit">
                                <?= Translation::get('save_button') ?>
                            </button>
                        </div>

                        <p style="color: red" class="col-sm-10">
                            <?= Translation::get('form_message_for_required_fields') ?>
                        </p>
                    </div>
                </form>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>