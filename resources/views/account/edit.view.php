<?php loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));

use App\services\core\Translation;
use App\services\security\CSRF;

$request = new  \App\services\core\Request();
?>
    <div class="container page" id="page">
        <div class="row mb-5">
            <div class="col-sm-11 m-auto">
                <h3>Account bewerken</h3>
            </div>

            <div class="col-sm-12">
                <form method="post" action="/account/updaten">
                    <?php
                    loadFile(RESOURCES_PATH . '/partials/flash.view.php');
                    echo CSRF::formToken('/account/updaten');
                    ?>

                    <div class="form-group">
                        <label for="name"><?= Translation::get('form_name') ?></label>
                        <input class="form-control" type="text" id="name" disabled minlength="2" maxlength="50"
                               value="<?= htmlspecialchars_decode($account->account_name ?? '') ?>">
                    </div>

                    <?php if (intval($account->account_rights ?? 0) === 1) : ?>
                        <div class="form-group">
                            <label for="education"><?= Translation::get('form_education') ?></label>
                            <input class="form-control" type="text" id="education" disabled
                                   value="<?= htmlspecialchars_decode($account->account_education ?? '') ?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="email"><?= Translation::get('form_email') ?></label>
                        <input class="form-control" id="email"
                               value="<?= htmlspecialchars_decode($account->account_email ?? '') ?>" disabled>
                    </div>

                    <div class="form-group">
                        <label for="currentPassword"><?= Translation::get('form_current_password') ?></label>
                        <span style="color: red">*</span>
                        <input class="form-control" type="password" id="currentPassword" name="currentPassword"
                               minlength="4" placeholder="<?= Translation::get('form_current_password') ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="password"><?= \App\services\core\Translation::get('form_password') ?></label>
                        <span style="color: red">*</span>
                        <input type="password" class="form-control" id="password" name="password" required minlength="4"
                               placeholder="<?= \App\services\core\Translation::get('form_password_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"><?= \App\services\core\Translation::get('form_confirm_password') ?></label>
                        <span style="color: red">*</span>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required
                               minlength="4"
                               placeholder="<?= \App\services\core\Translation::get('form_confirm_password_placeholder') ?>">
                    </div>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\services\core\Translation::get('save_button') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>