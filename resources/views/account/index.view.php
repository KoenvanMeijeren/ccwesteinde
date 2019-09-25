<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));

use App\services\security\CSRF; ?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <h3 class="font-weight-light"><?= \App\services\core\Translation::get('form_login_title') ?></h3>
            </div>

            <div class="col-sm-12">
                <form method="post" action="/inloggen">
                    <?php
                    loadFile(RESOURCES_PATH . '/partials/flash.view.php');
                    echo CSRF::formToken('/inloggen');
                    ?>
                    <div class="form-group">
                        <label for="email"><?= \App\services\core\Translation::get('form_email') ?></label>
                        <input type="email" class="form-control" id="email" autocomplete="off" autofocus required
                               name="email"
                               placeholder="<?= \App\services\core\Translation::get('form_email_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="password"><?= \App\services\core\Translation::get('form_password') ?></label>
                        <input type="password" class="form-control" id="password" required name="password"
                               placeholder="<?= \App\services\core\Translation::get('form_password_placeholder') ?>">
                    </div>

                    <button type="button" class="btn gray-bg text-white" onclick="return goBack()">
                        <?= \App\services\core\Translation::get('back_button') ?>
                    </button>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\services\core\Translation::get('login_button') ?>
                    </button>

                    <button type="button" class="btn green-bg text-white float-right"
                            onclick="window.location.href='/registreren'">
                        <?= \App\services\core\Translation::get('register_button') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>