<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\services\core\Translation;

$request = new \App\services\core\Request();
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
                    Bewerk hier een pagina.
                </p>
            </div>

            <div class="ml-5 mr-5 pb-5">
                <?php
                $action = '/admin/page/store';
                if (isset($page->page_ID)) {
                    $action = "/admin/page/" . ($page->page_ID ?? 0) . "/update";
                }
                ?>
                <form method="post" action="<?= $action ?>">
                    <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>

                    <?php if (intval($page->page_in_menu ?? 0) !== 3) : ?>
                        <div class="row form-group">
                            <label class="col-sm-2" for="show-in-menu">
                                <b><?= Translation::get('form_show_page_in_menu') ?></b><span
                                        style="color: red">*</span>
                            </label>

                            <div class="col-sm-10">
                                <label class="radio-inline"><input type="radio" name="inMenu"
                                                                   value="<?= \App\model\admin\page\Page::PAGE_NOT_IN_MENU ?>"
                                        <?= intval($page->page_in_menu ?? 0) ===
                                        \App\model\admin\page\Page::PAGE_NOT_IN_MENU ? 'checked' : '' ?>>
                                    <?= Translation::get('form_no') ?>
                                </label>
                                <label class="radio-inline"><input type="radio" name="inMenu"
                                                                   value="<?= \App\model\admin\page\Page::PAGE_PUBLIC_IN_MENU ?>"
                                        <?= intval($page->page_in_menu ?? 0) ===
                                        \App\model\admin\page\Page::PAGE_PUBLIC_IN_MENU ? 'checked' : '' ?>>
                                    <?= Translation::get('form_yes_public') ?>
                                </label>
                                <label class="radio-inline"><input type="radio" name="inMenu"
                                                                   value="<?= \App\model\admin\page\Page::PAGE_LOGGED_IN_IN_MENU ?>"
                                        <?= intval($page->page_in_menu ?? 0) ===
                                            \App\model\admin\page\Page::PAGE_LOGGED_IN_IN_MENU ? 'checked' : '' ?>>
                                    <?= Translation::get('form_yes_loggedIn') ?>
                                </label>
                                <label class="radio-inline"><input type="radio" name="inMenu"
                                                                   value="<?= \App\model\admin\page\Page::PAGE_IN_FOOTER ?>"
                                        <?= intval($page->page_in_menu ?? 0) ===
                                            \App\model\admin\page\Page::PAGE_IN_FOOTER ? 'checked' : '' ?>>
                                    <?= Translation::get('form_yes_in_footer') ?>
                                </label>
                                <label class="radio-inline"><input type="radio" name="inMenu"
                                                                   value="<?= \App\model\admin\page\Page::PAGE_IN_MENU_AND_IN_FOOTER ?>"
                                        <?= intval($page->page_in_menu ?? 0) ===
                                            \App\model\admin\page\Page::PAGE_IN_MENU_AND_IN_FOOTER ? 'checked' : '' ?>>
                                    <?= Translation::get('form_yes_and_in_footer') ?>
                                </label>
                            </div>
                        </div>
                    <?php else : ?>
                        <input type="hidden" name="inMenu" value="<?= intval($page->page_in_menu ?? 0) ?>">
                    <?php endif; ?>

                    <div class="row form-group">
                        <label class="col-sm-2" for="title">
                            <b><?= Translation::get('form_title') ?></b><span style="color: red">*</span>
                        </label>
                        <input class="form-control col-sm-10" id="title" name="title" type="text" required minlength="2"
                               placeholder="<?= Translation::get('form_title_placeholder') ?>" maxlength="255"
                               value="<?= !empty($request->post('title')) ? htmlspecialchars_decode($request->post('title')) :
                                   htmlspecialchars_decode($page->page_title ?? '') ?>"
                        >
                    </div>

                    <div class="row form-group">
                        <label class="col-sm-2" for="slug">
                            <b><?= Translation::get('form_page_slug') ?></b><span style="color: red">*</span>
                        </label>
                        <input class="form-control col-sm-10" id="slug" type="text" required minlength="2" name="slug"
                               placeholder="<?= Translation::get('form_page_slug_placeholder') ?>" maxlength="255"
                               value="<?= !empty($request->post('slug')) ? htmlspecialchars_decode($request->post('slug')) :
                                   htmlspecialchars_decode($page->page_slug_name ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="content">
                            <b><?= Translation::get('form_page_content') ?></b><span style="color: red">*</span>
                        </label>
                        <textarea id="content"
                                  name="content"><?= !empty($request->post('content')) ? parseHTMLEntities($request->post('content')) : parseHTMLEntities($page->page_content ?? '') ?></textarea>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success"
                                    onclick="window.location.href='/admin/pages'">
                                <?= Translation::get('back_button') ?>
                            </button>
                        </div>

                        <div class="col-sm-10">
                            <button type="submit" class="mr-2 btn default">
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