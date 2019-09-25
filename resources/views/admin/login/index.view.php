<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));

use App\services\core\Translation;
use App\services\security\CSRF;

?>
    <form class="login-container" method="post" action="/admin/login">
        <?php
        loadFile(RESOURCES_PATH . '/partials/flash.view.php');
        echo CSRF::formToken('/admin/login');
        ?>

        <h1><?= Translation::get('login_page_title') ?></h1>

        <div class="form-group">
            <label for="email"><b><?= Translation::get('form_email') ?></b></label>
            <input class="form-control" type="email" id="email" name="email" autofocus="autofocus" autocomplete="off"
                   required placeholder="<?= Translation::get('form_email_placeholder') ?>">
        </div>

        <div class="form-group">
            <label for="password"><b><?= Translation::get('form_password') ?></b></label>
            <input class="form-control" type="password" id="password" name="password" autocomplete="off" required
                   placeholder="<?= Translation::get('form_password_placeholder') ?>">
        </div>

        <button class="btn default w-100" type="submit"><?= Translation::get('login_button') ?></button>
    </form>

<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>