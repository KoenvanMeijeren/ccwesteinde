<?php use App\services\core\Translation;

loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <h3>
                    <?= \App\model\translation\Translation::get('meet_the_expert_aanmeldingen_beheren') ?>
                </h3>
            </div>
        </div>

        <div class="row mb-3">
            <?php if (isset($signUps) && !empty($signUps)) :
                foreach ($signUps as $signUp) : ?>
                    <div class="col-sm-6">
                        <div class="p-2 mb-1 mr-1 green-bg border-radius-5 text-white">
                            <form method="post"
                                  action="/aanmeldingen-en-reserveringen/beheren/aanmelding/<?= $signUp->signUp_ID ?? 0 ?>/verwijderen">
                                <button type="submit" class="btn btn-danger float-right"
                                        onclick="return confirm('<?= Translation::get('delete_sign_up_confirmation_message') ?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>


                            <h3><?= ucfirst($signUp->signUp_event_title ?? '') ?></h3>
                            <p>
                                <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_locatie') ?>
                                <?= $signUp->signUp_event_location ?? '' ?><br>

                                <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_datum') ?>
                                <?= parseToDate($signUp->signUp_event_start_datetime ?? '') ?><br>

                                <?= \App\model\translation\Translation::get('meet_the_expert_aanmelden_tijdstip') ?>
                                <?= parseToTime($signUp->signUp_event_start_datetime ?? '') ?> -
                                <?= parseToTime($signUp->signUp_event_end_datetime ?? '') ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach;
            else : ?>
                <div class="col-sm-11 m-auto">
                    <?= Translation::get('no_sign_ups_were_found_message') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-11 m-auto">
                <h3>
                    <?= \App\model\translation\Translation::get('werkplek_reserveringen_beheren') ?>
                </h3>
            </div>
        </div>

        <div class="row mb-3">
            <?php if (isset($workspaceReservations) && !empty($workspaceReservations)) :
                foreach ($workspaceReservations as $workspaceReservation) : ?>
                    <div class="col-sm-6">
                        <div class="p-2 mb-1 mr-1 green-bg border-radius-5 text-white">
                            <form method="post"
                                  action="/aanmeldingen-en-reserveringen/beheren/reservering/<?= $workspaceReservation->workspace_reservation_ID ?? 0 ?>/verwijderen">
                                <button type="submit" class="btn btn-danger float-right"
                                        onclick="return confirm('<?= Translation::get('delete_reservation_confirmation_message') ?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>

                            <h3><?= $workspaceReservation->workspace_name ?? '' ?></h3>
                            <p>
                                Gereserveerd op
                                <?= parseToDate($workspaceReservation->workspace_reservation_start_datetime ?? '') ?>
                                <br>
                                <?php if (parseToTime($workspaceReservation->workspace_reservation_start_datetime ?? '') < '12:00') : ?>
                                    In de ochtend
                                <?php else : ?>
                                    In de middag
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach;
            else : ?>
                <div class="col-sm-11 m-auto">
                    <?= Translation::get('no_reservations_were_found_message') ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-11 m-auto">
                <h3>
                    <?= \App\model\translation\Translation::get('vergaderruimte_reserveringen_beheren') ?>
                </h3>
            </div>
        </div>

        <div class="row">
            <?php if (isset($meetingRoomReservations) && !empty($meetingRoomReservations)) :
                foreach ($meetingRoomReservations as $meetingRoomReservation) : ?>
                    <div class="col-sm-6">
                        <div class="p-2 mb-1 mr-1 green-bg border-radius-5 text-white">
                            <form method="post"
                                  action="/aanmeldingen-en-reserveringen/beheren/reservering/<?= $meetingRoomReservation->workspace_reservation_ID ?? 0 ?>/verwijderen">
                                <button type="submit" class="btn btn-danger float-right"
                                        onclick="return confirm('<?= Translation::get('delete_reservation_confirmation_message') ?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>

                            <h3><?= $meetingRoomReservation->workspace_name ?? '' ?></h3>
                            <p>
                                Gereserveerd op
                                <?= parseToDate($meetingRoomReservation->workspace_reservation_start_datetime ?? '') ?>
                                <br>
                                Van <?= parseToTime($meetingRoomReservation->workspace_reservation_start_datetime ?? '') ?>
                                uur tot en met
                                <?= parseToTime($meetingRoomReservation->workspace_reservation_end_datetime ?? '') ?>
                                uur
                            </p>
                        </div>
                    </div>
                <?php endforeach;
            else : ?>
                <div class="col-sm-11 m-auto">
                    <?= Translation::get('no_reservations_were_found_message') ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>