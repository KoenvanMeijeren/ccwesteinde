<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
$request = new  \App\services\core\Request();
$settings = new \App\model\admin\settings\Settings();
use App\services\security\CSRF; ?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <h3 class="font-weight-light"><?= \App\services\core\Translation::get('form_register_title') ?></h3>
            </div>

            <div class="col-sm-12">
                <form method="post" action="/registreren">
                    <?php
                    loadFile(RESOURCES_PATH . '/partials/flash.view.php');
                    echo CSRF::formToken('/registreren');
                    ?>

                    <div class="form-group">
                        <label for="name"><?= \App\services\core\Translation::get('form_name') ?></label>
                        <span style="color: red">*</span>
                        <input type="text" class="form-control" id="name" required name="name" autocomplete="off"
                               autocapitalize="on" minlength="2" maxlength="50"
                               value="<?= !empty($request->post('name')) ? htmlspecialchars_decode($request->post('name')) : '' ?>"
                               placeholder="<?= \App\services\core\Translation::get('form_name_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="education"><?= \App\services\core\Translation::get('form_education') ?></label>
                        <span style="color: red">*</span>
                        <input type="text" class="form-control" id="education" required name="education" autocomplete="off"
                               autocapitalize="on" minlength="2" maxlength="50"
                               value="<?= !empty($request->post('education')) ?
                                   htmlspecialchars_decode($request->post('education')) : '' ?>"
                               placeholder="<?= \App\services\core\Translation::get('form_education_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="front-piece-email"><?= \App\services\core\Translation::get('form_email') ?></label>
                        <span style="color: red">*</span>
                        <div class="form-row align-items-center">
                            <div class="col-auto">
                                <input type="text" class="form-control" id="front-piece-email" name="frontPieceEmail"
                                       autocomplete="off" autofocus required minlength="2" maxlength="12"
                                       value="<?= !empty($request->post('frontPieceEmail')) ?
                                           htmlspecialchars_decode($request->post('frontPieceEmail')) : '' ?>"
                                       placeholder="<?= \App\services\core\Translation::get('form_email_placeholder') ?>">
                            </div>
                            <div class="col-auto">
                                <div class="input-group-text">@<?= $settings->get('studentEmail') ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password"><?= \App\services\core\Translation::get('form_password') ?></label>
                        <span style="color: red">*</span>
                        <input type="password" class="form-control" id="password" required name="password" minlength="1"
                               placeholder="<?= \App\services\core\Translation::get('form_password_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword"><?= \App\services\core\Translation::get('form_confirm_password') ?></label>
                        <span style="color: red">*</span>
                        <input type="password" class="form-control" id="confirmPassword" required name="confirmPassword"
                               minlength="1"
                               placeholder="<?= \App\services\core\Translation::get('form_confirm_password_placeholder') ?>">
                    </div>

                    <button type="button" class="btn gray-bg text-white" onclick="window.location.href='/inloggen'">
                        <?= \App\services\core\Translation::get('back_button') ?>
                    </button>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\services\core\Translation::get('register_button') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>