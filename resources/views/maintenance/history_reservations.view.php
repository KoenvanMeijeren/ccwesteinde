<?php

use App\services\core\Translation;
use Cake\Chronos\Chronos;

$signUpPerEvent = new \App\model\signUp\SignUp();
$reservation = new \App\model\reservation\Reservation();
$request = new \App\services\core\Request();
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-10 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <h3>Historie van <?= $request->get('space') ?> reserveringen</h3>
                <p>
                    Een overzicht van alle reserveringen. Het percentage naast een dag geeft de bezettingsgraad weer.
                </p>
            </div>

            <div class="col-sm-1">
                <button type="button" class="btn default-bg text-white float-right"
                        onclick="window.location.href='/reserveringen/beheren?space=<?= $request->get('space') ?>'">
                    Reserveringen beheren
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-11 m-auto">
                <form method="get" class="form-inline">
                    <input type="hidden" name="space" value="<?= $request->get('space') ?>">

                    <div class="form-group">
                        <label for="limit" class="mr-2"><?= Translation::get('filter_records') ?></label>
                        <input type="number" min="1" step="1" name="limit" id="limit" class="form-control"
                               value="<?= !empty(intval($request->get('limit'))) ? intval($request->get('limit')) : 1 ?>">
                    </div>

                    <button type="submit" class="btn default-bg text-white ml-2">
                        <?= Translation::get('days_button') ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-sm-4">
                <div class="list-group" id="list-tab" role="tablist">
                    <?php $active = 'active';
                    $date = new \Cake\Chronos\Chronos();
                    $date = $date->addDay(-1);
                    for ($x = 0; $x < intval($request->get('limit')); $x++) :
                        if ($date->isWeekend()) {
                            if ($date->isSaturday()) {
                                $date = $date->addDay(-1);
                            } elseif ($date->isSunday()) {
                                $date = $date->addDay(-2);
                            }
                        }

                        if (!$date->isWeekend()) : ?>
                            <a class="list-group-item list-group-item-action <?= $active ?>"
                               id="list-<?= $x ?>-list" data-toggle="list" href="#list-<?= $x ?>" role="tab"
                               aria-controls="<?= $x ?>">
                                <?= parseToDate($date->toDateString()) ?>
                                <span class="badge green-bg text-white badge-pill float-right">
                                   <?php if ($request->get('space') === 'werkplek') : ?>
                                       <?= $reservation->calculateWorkspaceOccupancyRating(
                                           $date, $maximumReservations ?? 1) ?>%
                                   <?php elseif ($request->get('space') === 'vergaderruimte') : ?>
                                       <?= $reservation->calculateMeetingRoomOccupancyRating($date) ?>%
                                   <?php endif; ?>
                                </span>
                            </a>
                        <?php endif;
                        $active = '';
                        $date = $date->addDay(-1);
                    endfor; ?>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="tab-content" id="nav-tabContent">
                    <?php $active = 'active';
                    $show = 'show';
                    $date = new \Cake\Chronos\Chronos();
                    $date = $date->addDay(-1);
                    for ($x = 0; $x < intval($request->get('limit')); $x++) :
                        if ($date->isWeekend()) {
                            if ($date->isSaturday()) {
                                $date = $date->addDay(-1);
                            } elseif ($date->isSunday()) {
                                $date = $date->addDay(-2);
                            }
                        }

                        if (!$date->isWeekend()) : ?>
                            <div class="tab-pane fade <?= $show ?> <?= $active ?>" id="list-<?= $x ?>" role="tabpanel"
                                 aria-labelledby="list-<?= $x ?>-list">
                                <?php if (!empty($workspaces ?? []) && is_array($workspaces ?? [])) :
                                    foreach ($workspaces ?? [] as $workspace) :
                                        $workspaceReservations = $reservation->getAllByWorkspaceByDate(
                                            $workspace->workspace_ID ?? 0,
                                            $date->toDateString() . ' 00:00:00',
                                            $date->toDateString() . ' 23:59:59'
                                        );

                                        $filledMinutes = 0;
                                        if (!empty($workspaceReservations) && \is_array($workspaceReservations)) {
                                            foreach ($workspaceReservations as $workspaceReservation) {
                                                $reservationStartDate = new Chronos($workspaceReservation->workspace_reservation_start_datetime ?? '');
                                                $reservationEndDate = new Chronos($workspaceReservation->workspace_reservation_end_datetime ?? '');

                                                $filledMinutes += $reservationEndDate->diffInMinutes($reservationStartDate);
                                            }
                                        }

                                        $occupancyRating = $filledMinutes / (int) ($quantityOptions ?? 1);
                                        $occupancyRate = (int) (number_format($occupancyRating * 100, 0));
                                        ?>
                                        <ul class="pl-3">
                                            <li class="list-group">
                                                <h4>
                                                    <?= $workspace->workspace_name ?? '' ?>
                                                    <?php if ($occupancyRate === 0) : ?>
                                                        - <span class="green-text">onbezet</span>
                                                    <?php elseif ($occupancyRate === 50) : ?>
                                                        - <span class="default-text">halfvol</span>
                                                    <?php elseif ($occupancyRate === 100) : ?>
                                                        - <span class="red-text">vol</span>
                                                    <?php else : ?>
                                                        - voor <?= $occupancyRate ?>% van de dag bezet
                                                    <?php endif; ?>
                                                </h4>
                                            </li>
                                            <?php if (!empty($workspaceReservations) && is_array($workspaceReservations)) :
                                                foreach ($workspaceReservations as $workspaceReservation) : ?>
                                                    <li class="list-group-item">
                                                        <h5>
                                                            Gereserveerd
                                                            <?php if (parseToTime($workspaceReservation->workspace_reservation_start_datetime ?? '') === '00:00' &&
                                                                parseToTime($workspaceReservation->workspace_reservation_end_datetime ?? '') === '11:59') : ?>
                                                                in de ochtend
                                                            <?php elseif (parseToTime($workspaceReservation->workspace_reservation_start_datetime ?? '') === '12:01' &&
                                                                parseToTime($workspaceReservation->workspace_reservation_end_datetime ?? '') === '23:59') : ?>
                                                                in de middag
                                                            <?php else : ?>
                                                                van
                                                                <?= parseToTime($workspaceReservation->workspace_reservation_start_datetime ?? '') ?>
                                                                -
                                                                <?= parseToTime($workspaceReservation->workspace_reservation_end_datetime ?? '') ?>
                                                                uur
                                                            <?php endif; ?>
                                                        </h5>
                                                        <p>
                                                            Door: <?= $workspaceReservation->account_name ?? '' ?><br>
                                                            Email: <?= $workspaceReservation->account_email ?? '' ?><br>
                                                            <?php if (isset($workspaceReservation->account_education)
                                                                && !empty($workspaceReservation->account_education)) : ?>
                                                                Opleiding: <?= $workspaceReservation->account_education ?? '' ?>
                                                                <br>
                                                            <?php endif; ?>
                                                        </p>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <li class="list-group-item">
                                                    <p>
                                                        Er is geen reservering gevonden voor deze werkplek.
                                                    </p>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <p class="ml-3">
                                        Er zijn geen reserveringen gevonden.
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endif;
                        $active = '';
                        $show = '';
                        $date = $date->addDay(-1);
                    endfor; ?>
                </div>
            </div>
        </div>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>