<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
$user = new \App\model\admin\account\User();
?>
    <img class="project-image desktop"
         width="100%"
         src="<?= loadImage($event->banner_path ?? '', '/resources/assets/images/project_background.jpg') ?>"
         alt="<?= $event->event_title ?? '' ?>">

    <img class="project-image mobile"
         width="100%"
         height="300px"
         src="<?= loadImage($event->thumbnail_path ?? '',
             '/resources/assets/images/square_picture_project_background.jpg') ?>"
         alt="<?= $event->event_title ?? '' ?>">

    <div class="container page pt-0 mt-0">
        <div class="row d-flex justify-content-between">
            <div class="main <?= intval($event->event_is_archived ?? 0) === 0 && !empty($user->getRights()) ? 'col-sm-9' : 'col-sm-12' ?>">
                <?= parseHTMLEntities($event->event_content ?? '') ?>
            </div>

            <?php if (intval($event->event_is_archived ?? 0) === 0 && !empty($user->getRights())) : ?>
                <div style="padding-left: 20px !important;" class="col-sm-3 sidebar">
                    <h3>
                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_titel') ?>
                    </h3>
                    <p>
                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_locatie') ?>
                        <?= $event->event_location ?? '' ?><br>

                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_datum') ?>
                        <?= parseToDate($event->event_start_datetime ?? '') ?><br>

                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_tijdstip') ?>
                        <?= parseToTime($event->event_start_datetime ?? '') ?> -
                        <?= parseToTime($event->event_end_datetime ?? '') ?><br>
                        <?php
                        $division = intval($event->event_sign_ups ?? 1) / intval($event->event_maximum_persons ?? 1);
                        $division = intval(number_format($division * 100, 0));

                        if ($division >= 75 && $division <= 100) : ?>
                            <span class="red-text">
                                <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_beschikbare_plekken') ?>
                                <?= intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) ?>
                            </span>
                        <?php elseif ($division > 25 && $division < 75) : ?>
                            <span class="default-text">
                                <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_beschikbare_plekken') ?>
                                <?= intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) ?>
                            </span>
                        <?php else : ?>
                            <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_beschikbare_plekken') ?>
                            <?= intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) ?>
                        <?php endif; ?>
                    </p>

                    <?php if (isset($signUpsNumber) && $signUpsNumber >= 1) : ?>
                        <p class="green-text">
                            <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_ingeschreven_tekst') ?>
                        </p>
                    <?php elseif (intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) === 0) : ?>
                        <p class="red-text">
                            <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_is_vol_tekst') ?>
                        </p>
                    <?php else : ?>
                        <button class="float-right green-bg text-white" type="button"
                            <?= intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) === 0 ? 'disabled' : '' ?>
                                onclick="window.location.href='/meet-the-expert/<?= $event->event_ID ?? 0 ?>/aanmelden'">
                            <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_knop_tekst') ?>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>