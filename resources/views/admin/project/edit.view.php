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
                    Bewerk hier een project.
                </p>
            </div>

            <div class="ml-5 mr-5 pb-5">
                <?php
                $action = '/admin/project/store';
                if (isset($project->project_ID)) {
                    $action = "/admin/project/" . ($project->project_ID ?? 0) . "/update";
                }
                ?>
                <form method="post" action="<?= $action ?>" enctype="multipart/form-data">
                    <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>

                    <div class="row form-group">
                        <label class="col-sm-2" for="title">
                            <b><?= Translation::get('form_title') ?></b><span style="color: red">*</span>
                        </label>
                        <input class="form-control col-sm-10" id="title" name="title" type="text" required minlength="2"
                               placeholder="<?= Translation::get('form_title_placeholder') ?>" maxlength="255"
                               value="<?= !empty($request->post('title')) ? htmlspecialchars_decode($request->post('title')) :
                                   htmlspecialchars_decode($project->project_title ?? '') ?>">
                    </div>

                    <div class="row form-group">
                        <label class="col-sm-2" for="inputImage">
                            <b><?= Translation::get('form_thumbnail_picture') ?></b><br>
                            <?= Translation::get('form_recommended_thumbnail_picture_size') ?>
                            <?= !empty($project->project_thumbnail_path ?? '') ? '' : '<span style="color: red">*</span>' ?>
                        </label>

                        <div class="col-sm-2 ml-0 pl-0">
                            <h5>Huidig</h5>
                            <img src="<?= $project->project_thumbnail_path ?? '' ?>" id="thumbnailOutput"
                                 alt="Thumbnail">
                            <input type="hidden" name="thumbnail" id="thumbnailInputOutput">
                        </div>
                        <div class="col-sm-8">
                            <h5>Nieuw (optioneel)</h5>
                            <input class="form-control form-control-file col-sm-10" id="inputThumbnail" type="file">
                        </div>
                    </div>

                    <div class="thumbnailProgress progress">
                        <div class="thumbnail-progress-bar progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                        </div>
                    </div>

                    <div class="thumbnailAlert alert" role="alert"></div>
                    <div class="modal fade thumbnailModal" id="modal" tabindex="-1" role="dialog"
                         aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Foto bijsnijden</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img class="image" id="thumbnailImage" src="" alt="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Annuleren
                                    </button>
                                    <button type="button" class="btn btn-primary" id="cropThumbnail">
                                        Bijsnijden
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-sm-2" for="bannerInput">
                            <b><?= Translation::get('form_banner_picture') ?></b><br>
                            <?= Translation::get('form_recommended_banner_picture_size') ?>
                            <?= !empty($project->project_banner_path ?? '') ? '' : '<span style="color: red">*</span>' ?>
                        </label>

                        <div class="col-sm-2 ml-0 pl-0">
                            <h5>Huidig</h5>
                            <img src="<?= $project->project_banner_path ?? '' ?>" id="bannerOutput" alt="Banner">
                            <input type="hidden" name="banner" id="bannerInputOutput">
                        </div>
                        <div class="col-sm-8">
                            <h5>Nieuw (optioneel)</h5>
                            <input class="form-control form-control-file col-sm-10" id="bannerInput" type="file">
                        </div>
                    </div>

                    <div class="bannerProgress progress">
                        <div class="banner-progress-bar progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                        </div>
                    </div>

                    <div class="bannerAlert alert" role="alert"></div>
                    <div class="modal fade bannerModal" id="modal" tabindex="-1" role="dialog"
                         aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Foto bijsnijden</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img class="image" id="bannerImage" src="" alt="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Annuleren
                                    </button>
                                    <button type="button" class="btn btn-primary" id="cropBanner">
                                        Bijsnijden
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row form-group">
                        <label class="col-sm-2" for="headerInput">
                            <b><?= Translation::get('form_header_picture') ?></b><br>
                            <?= Translation::get('form_recommended_header_picture_size') ?>
                            <?= !empty($project->project_header_path ?? '') ? '' : '<span style="color: red">*</span>' ?>
                        </label>

                        <div class="col-sm-2 ml-0 pl-0">
                            <h5>Huidig</h5>
                            <img src="<?= $project->project_header_path ?? '' ?>" id="headerOutput" alt="Header">
                            <input type="hidden" name="header" id="headerInputOutput">
                        </div>
                        <div class="col-sm-8">
                            <h5>Nieuw (optioneel)</h5>
                            <input class="form-control form-control-file col-sm-10" id="headerInput" type="file">
                        </div>
                    </div>

                    <div class="headerProgress progress">
                        <div class="header-progress-bar progress-bar progress-bar-striped progress-bar-animated"
                             role="progressbar"
                             aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                        </div>
                    </div>

                    <div class="headerAlert alert" role="alert"></div>
                    <div class="modal fade headerModal" id="modal" tabindex="-1" role="dialog"
                         aria-labelledby="modalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalLabel">Foto bijsnijden</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="img-container">
                                        <img class="image" id="headerImage" src="" alt="">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                        Annuleren
                                    </button>
                                    <button type="button" class="btn btn-primary" id="cropHeader">
                                        Bijsnijden
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">
                            <b><?= Translation::get('form_project_content') ?></b><span style="color: red">*</span>
                        </label>
                        <textarea id="content"
                                  name="content"><?= !empty($request->post('content')) ? parseHTMLEntities($request->post('content')) : parseHTMLEntities($project->project_content ?? '') ?></textarea>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2">
                            <button type="button" class="btn btn-success"
                                    onclick="window.location.href='/admin/projects'">
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