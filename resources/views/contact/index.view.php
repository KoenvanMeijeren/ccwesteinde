<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));

use App\services\security\CSRF;
$request = new \App\services\core\Request();
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>

            <div class="col-sm-12 mb-3">
                <form method="post" id="form" action="/contact">
                    <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                    <?= CSRF::formToken('/contact') ?>

                    <div class="form-group">
                        <label for="branch">
                            <?= \App\model\translation\Translation::get('formulier_werkveld_label') ?>
                        </label>
                        <span style="color: red">*</span>
                        <select id="branch" name="branch" class="form-control" required>
                            <option value="" selected>
                                <?= \App\model\translation\Translation::get('formulier_werkveld_kiezen') ?>
                            </option>
                            <?php if (isset($contacts) && !empty($contacts)) :
                                foreach ($contacts as $contact) : ?>
                                    <option value="<?= $contact->contact_ID ?? 0 ?>"
                                        <?= intval($request->post('branch')) === ($contact->contact_ID ?? 0) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars_decode(($contact->branch_name ?? ''))
                                        . ' (' . htmlspecialchars_decode(($contact->landscape_name ?? ''))
                                        . ') - ' . htmlspecialchars_decode(($contact->contact_name ?? '')) ?>
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <?= \App\model\translation\Translation::get('formulier_email') ?>
                        </label>
                        <span style="color: red">*</span>
                        <input type="email" class="form-control" id="email" autocomplete="off"
                               required minlength="2" maxlength="100" name="email" value="<?= $request->post('email') ?>"
                               placeholder="<?= \App\model\translation\Translation::get('formulier_email_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="subject">
                            <?= \App\model\translation\Translation::get('formulier_onderwerp') ?>
                        </label>
                        <span style="color: red">*</span>
                        <input type="text" class="form-control" id="subject" required minlength="2"
                               maxlength="50" name="subject" value="<?= $request->post('subject') ?>"
                               placeholder="<?= \App\model\translation\Translation::get('formulier_onderwerp_placeholder') ?>">
                    </div>

                    <div class="form-group">
                        <label for="message">
                            <?= \App\model\translation\Translation::get('formulier_bericht') ?>
                        </label>
                        <span style="color: red">*</span>
                        <textarea class="form-control" id="message" name="message" minlength="2" rows="10"
                                  placeholder="<?= \App\model\translation\Translation::get('formulier_bericht_placeholder') ?>"
                                  required><?= $request->post('message') ?></textarea>
                    </div>

                    <button type="submit" class="btn green-bg text-white g-recaptcha"
                            data-sitekey="<?= \App\services\core\Config::get('recaptcha_public_key') ?>"
                            data-callback="onSubmit">
                        <?= \App\model\translation\Translation::get('formulier_verzenden') ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>