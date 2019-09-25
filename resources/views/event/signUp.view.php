<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));

use Cake\Chronos\Chronos;

$date = new Chronos();
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-12">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
            </div>

            <div class="col-sm-6 mb-1">
                <h3>
                    <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_tekst_voor_sessie_titel') ?>
                    <?= ucfirst($event->event_title ?? '') ?>
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

                    <button type="button" class="btn gray-bg text-white"
                            onclick="window.location.href='/meet-the-experts'">
                        <?= \App\services\core\Translation::get('back_button') ?>
                    </button>
                <?php elseif (intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) === 0) : ?>
                    <p class="red-text">
                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_is_vol_tekst') ?>
                    </p>

                    <button type="button" class="btn gray-bg text-white"
                            onclick="window.location.href='/meet-the-experts'">
                        <?= \App\services\core\Translation::get('back_button') ?>
                    </button>
                <?php elseif (strtotime($event->event_start_datetime ?? '') < strtotime($date->toDateTimeString())) : ?>
                    <p>
                        <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_is_niet_meer_mogelijk_tekst') ?>
                    </p>

                    <button type="button" class="btn gray-bg text-white"
                            onclick="window.location.href='/meet-the-experts'">
                        <?= \App\services\core\Translation::get('back_button') ?>
                    </button>
                <?php else: ?>
                    <form method="post" action="/meet-the-expert/<?= $event->event_ID ?? 0 ?>/aanmelden">
                        <?= \App\services\security\CSRF::formToken('/meet-the-expert/' . ($event->event_ID ?? 0) . '/aanmelden') ?>

                        <button type="button" class="btn gray-bg text-white"
                                onclick="window.location.href='/meet-the-experts'">
                            <?= \App\services\core\Translation::get('back_button') ?>
                        </button>

                        <button type="submit" class="btn green-bg text-white"
                            <?= intval($event->event_maximum_persons ?? 0) - intval($event->event_sign_ups ?? 0) === 0 ? 'disabled' : '' ?>>
                            <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_knop_tekst') ?>
                        </button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="col-sm-6 mb-1">
                <img src="<?= loadImage($event->thumbnail_path ?? '',
                    '/resources/assets/images/square_picture_project_background.jpg') ?>"
                     width="100%" height="300px" alt="<?= $event->event_title ?? '' ?>">
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>