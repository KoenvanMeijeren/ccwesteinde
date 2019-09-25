<?php use App\services\core\Translation;
$request = new \App\services\core\Request();
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div class="container page specialPadding" id="page">
        <div class="row">
            <div class="col-sm-11 specialPadding m-auto">
                <h3>Meet the Expert bewerken</h3>
            </div>
        </div>

        <div class="row">
            <?php
            $action = 'store';
            if (isset($event->event_ID)) {
                $action = "update";
            }
            ?>
            <form method="post" action="<?= $action ?>" enctype="multipart/form-data">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>

                <div class="row form-group">
                    <label class="col-sm-2" for="title">
                        <b><?= Translation::get('form_title') ?></b><span style="color: red">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input class="form-control" id="title" name="title" type="text" required minlength="2"
                               placeholder="<?= Translation::get('form_title_placeholder') ?>" maxlength="255"
                               value="<?= !empty($request->post('title')) ?
                                   htmlspecialchars_decode($request->post('title')) :
                                   htmlspecialchars_decode($event->event_title ?? '') ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-sm-2" for="thumbnail">
                        <b><?= Translation::get('form_thumbnail_picture') ?></b><br>
                        <?= Translation::get('form_recommended_thumbnail_picture_size') ?>
                        <?= !empty($event->thumbnail_path ?? '') ? '' : '<span style="color: red">*</span>' ?>
                    </label>

                    <div class="col-sm-4">
                        <h5>Huidig</h5>
                        <img class="mw-100" src="<?= $event->thumbnail_path ?? '' ?>" id="thumbnailOutput"
                             alt="Thumbnail">
                        <input type="hidden" name="thumbnail" id="thumbnailInputOutput">
                    </div>

                    <div class="col-sm-6">
                        <h5>Nieuw (optioneel)</h5>
                        <input class="form-control form-control-file" id="inputThumbnail" type="file">
                    </div>
                </div>

                <div class="thumbnailProgress progress">
                    <div class="thumbnail-progress-bar progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                    </div>
                </div>

                <div id="alert" class="thumbnailAlert alert" role="alert"></div>
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
                                    <img id="thumbnailImage" src="" alt="">
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
                    <label class="col-sm-2" for="banner">
                        <b><?= Translation::get('form_header_picture') ?></b><br>
                        <?= Translation::get('form_recommended_header_picture_size') ?>
                        <?= !empty($event->banner_path ?? '') ? '' : '<span style="color: red">*</span>' ?>
                    </label>

                    <div class="col-sm-4">
                        <h5>Huidig</h5>
                        <img class="mw-100" src="<?= $event->banner_path ?? '' ?>" id="headerOutput" alt="Header">
                        <input type="hidden" name="header" id="headerInputOutput">
                    </div>
                    <div class="col-sm-6">
                        <h5>Nieuw (optioneel)</h5>
                        <input class="form-control form-control-file" id="headerInput" type="file">
                    </div>
                </div>

                <div class="headerProgress progress">
                    <div class="header-progress-bar progress-bar progress-bar-striped progress-bar-animated"
                         role="progressbar"
                         aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%
                    </div>
                </div>

                <div id="alert"  class="headerAlert alert" role="alert"></div>
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
                                    <img id="headerImage" src="" alt="">
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

                <div class="row form-group">
                    <label class="col-sm-2" for="date-picker">
                        <b><?= \App\services\core\Translation::get('form_date') ?></b>
                        <span style="color: red">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="date" id="date-picker"
                               value="<?= !empty($request->post('date')) ?
                                   htmlspecialchars_decode($request->post('date')) :
                                   parseToDateInput($event->event_start_datetime ?? date('Y-m-d')) ?>" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-sm-2" for="time">
                        <b><?= \App\services\core\Translation::get('form_start_time') ?></b><span style="color: red">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="startTime" id="time"
                               value="<?= !empty($request->post('startTime')) ?
                                   htmlspecialchars_decode($request->post('startTime')) :
                                   parseToTimeInput($event->event_start_datetime ?? date('H:i')) ?>" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-sm-2" for="time1">
                        <b><?= \App\services\core\Translation::get('form_end_time') ?></b><span style="color: red">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="endTime" id="time1"
                               value="<?= !empty($request->post('endTime')) ?
                                   htmlspecialchars_decode($request->post('endTime')) :
                                   parseToTimeInput($event->event_end_datetime ?? date('H:i')) ?>" required>
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-sm-2" for="location">
                        <b><?= Translation::get('form_location') ?></b><span style="color: red">*</span>
                    </label>
                    <div class="col-sm-10">
                        <input class="form-control" id="location" name="location" type="text" required
                               minlength="2"
                               placeholder="<?= Translation::get('form_location_placeholder') ?>" maxlength="255"
                               value="<?= !empty($request->post('location')) ?
                                   htmlspecialchars_decode($request->post('location')) :
                                   htmlspecialchars_decode($event->event_location ?? '') ?>">
                    </div>
                </div>

                <div class="row form-group">
                    <label class="col-sm-2" for="maximumSignUps">
                        <b><?= \App\services\core\Translation::get('form_maximum_persons') ?></b>
                        <span style="color: red">*</span>
                    </label>

                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="maximumSignUps" name="maximumSignUps"
                               placeholder="<?= Translation::get('form_maximum_persons_placeholder') ?>"
                               value="<?= !empty($request->post('maximumSignUps')) ?
                                   htmlspecialchars_decode($request->post('maximumSignUps')) :
                                   htmlspecialchars_decode($event->event_maximum_persons ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="content">
                        <b><?= Translation::get('form_page_content') ?></b><span style="color: red">*</span>
                    </label>

                    <textarea id="content" class="m-0 p-0"
                              name="content"><?= !empty($request->post('content')) ?
                            parseHTMLEntities($request->post('content')) :
                            parseHTMLEntities($event->event_content ?? '') ?></textarea>
                </div>

                <div class="row form-group">
                    <div class="col-sm-2">
                        <button type="button" class="btn gray-bg text-white m-1"
                                onclick="window.location.href='/events'">
                            <?= Translation::get('back_button') ?>
                        </button>
                    </div>

                    <div class="col-sm-10">
                        <button type="submit" class="m-1 btn green-bg text-white">
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
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>