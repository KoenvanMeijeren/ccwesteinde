<?php
loadFile(RESOURCES_PATH . '/partials/admin/header.view.php', compact('title'));
loadFile(RESOURCES_PATH . '/partials/admin/menu.view.php');

use App\services\core\Translation;

$user = new \App\model\admin\account\User();
?>
    <body>
<div class="page-wrapper">
    <!-- PAGE CONTAINER-->
    <div class="page-container">
        <!-- HEADER DESKTOP-->
        <header class="header-desktop">
            <h1 class="ml-5 mt-3"><?= $title ?? '' ?></h1>
        </header>
        <!-- HEADER DESKTOP-->

        <!-- MAIN CONTENT-->
        <div class="main-content">
            <div class="ml-5 mr-5">
                <nav>
                    <div class="nav nav-tabs menu" id="nav-tab" role="tablist">
                        <a class="item-menu active" id="nav-company-settings-tab" data-toggle="tab"
                           href="#nav-company-settings" role="tab" aria-controls="nav-home" aria-selected="true">
                            <?= Translation::get('admin_company_settings_title') ?>
                        </a>
                        <a class="item-menu" id="nav-social-media-tab" data-toggle="tab"
                           href="#nav-social-media" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <?= Translation::get('admin_social_settings_title') ?>
                        </a>
                        <a class="item-menu" id="nav-email-media-tab" data-toggle="tab"
                           href="#nav-email-media" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <?= Translation::get('admin_email_settings_title') ?>
                        </a>
                        <a class="item-menu" id="nav-regular-media-tab" data-toggle="tab"
                           href="#nav-regular-media" role="tab" aria-controls="nav-profile" aria-selected="false">
                            <?= Translation::get('admin_regular_settings_title') ?>
                        </a>
                    </div>
                </nav>
                <form method="post" action="/admin/settings/store" enctype="multipart/form-data">
                    <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                    <?= \App\services\security\CSRF::formToken('/admin/settings/store') ?>

                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-company-settings" role="tabpanel"
                             aria-labelledby="nav-company-settings-tab">
                            <div class="mt-3 ">
                                <?php loadFile(RESOURCES_PATH . '/partials/forms/settings/company-settings.view.php'); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-social-media" role="tabpanel"
                             aria-labelledby="nav-social-media-tab">
                            <div class="mt-3 ">
                                <?php loadFile(RESOURCES_PATH . '/partials/forms/settings/social-media.view.php'); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-email-media" role="tabpanel"
                             aria-labelledby="nav-email-media-tab">
                            <div class="mt-3 ">
                                <?php loadFile(RESOURCES_PATH . '/partials/forms/settings/email.view.php'); ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-regular-media" role="tabpanel"
                             aria-labelledby="nav-regular-media-tab">
                            <div class="mt-3 ">
                                <?php loadFile(RESOURCES_PATH . '/partials/forms/settings/regular.view.php'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn default mr-2" type="submit"
                                <?= $user->getRights() >= 3 ? '' : 'disabled' ?>>
                                <?= Translation::get('save_button') ?>
                            </button>

                            <span style="color: red"><?= Translation::get('form_message_for_required_fields') ?></span>
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