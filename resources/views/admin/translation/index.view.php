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
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>

                <p>
                    Overzicht van alle teksten die worden gebruikt in de website.
                </p>

                <form method="post" action="/admin/translation/update">
                    <?= \App\services\security\CSRF::formToken('/admin/translation/update') ?>

                    <label><b>Huidige teksten bijwerken</b></label>
                    <div class="form-group">
                        <button type="submit" class="btn default"
                            <?= $user->getRights() >= 3 ? '' : 'disabled' ?>>
                            <?= \App\services\core\Translation::get('save_button') ?>
                        </button>
                    </div>

                    <?php if (isset($translations) && !empty($translations)) :
                        foreach ($translations as $translation) : ?>
                            <div class="row form-group">
                                <div class="col-sm-5">
                                    <input type="text" class="form-control m-1"
                                           value="<?= $translation['translation_name'] ?? '' ?>" disabled>
                                </div>

                                <div class="col-sm-5">
                                    <input type="text" class="form-control m-1" id="value"
                                           name="<?= $translation['translation_name'] ?? '' ?>" required
                                           value="<?= !empty($request->post($translation['translation_name'] ?? '')) ?
                                               parseHTMLEntities($request->post($translation['translation_name'] ?? '')) :
                                               parseHTMLEntities($translation['translation_value'] ?? '') ?>"
                                           placeholder="<?= \App\services\core\Translation::get('form_translation_value') ?>">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <?= \App\services\core\Translation::get('no_translations_were_found_message') ?><br>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <!-- END MAIN CONTENT-->
        <!-- END PAGE CONTAINER-->
    </div>
</div>
<?php loadFile(RESOURCES_PATH . '/partials/admin/footer.view.php'); ?>