<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
$request = new \App\services\core\Request();
$date = new \Cake\Chronos\Chronos();

if ($date->isWeekend()) {
    if ($date->isSaturday()) {
        $date = $date->addDay(2);
    } elseif ($date->isSunday()) {
        $date = $date->addDay(1);
    }
}

$settings = new \App\model\admin\settings\Settings();
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <h3><?= ucfirst($kind ?? '') ?> reserveren</h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-1 border-right">
                <form method="get" action="/werkplek/reserveren/stap-3">
                    <input type="hidden" name="kind" value="<?= $request->get('kind') ?>">

                    <div class="form-group date"
                         id="<?= intval($request->get('kind')) === 9 ? 'workspace-date-picker' : 'date-picker' ?>">
                        <label for="date">
                            <?= \App\model\translation\Translation::get('formulier_datum') ?>
                        </label>
                        <span style="color: red">*</span>
                        <input type="text" class="form-control" id="date" name="date" required
                               min="<?= parseToDateInput($date->toDateString()) ?>"
                               value="<?= !empty($request->get('date')) ?
                                   parseToDateInput($request->get('date')) :
                                   parseToDateInput($date->toDateString()) ?>"
                               autocomplete="off">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                    </div>

                    <?php if (intval($request->get('kind')) === 9) : ?>
                        <div class="form-group">
                            <label for="dayPart">
                                <?= \App\model\translation\Translation::get('formulier_dagdeel') ?>
                            </label>
                            <span style="color: red">*</span>
                            <select class="form-control" id="dayPart" name="dayPart" required>
                                <option value="morning" <?= $request->get('dayPart') === 'afternoon' ? 'selected' : '' ?>
                                <?= $date->toTimeString() < '12:00:00' ? 'selected' : '' ?>>
                                    <?= \App\services\core\Translation::get('form_dayPart_morning') ?></option>
                                <option value="afternoon" <?= $request->get('dayPart') === 'afternoon' ? 'selected' : '' ?>
                                    <?= $date->toTimeString() > '12:00:01' ? 'selected' : '' ?>>
                                    <?= \App\services\core\Translation::get('form_dayPart_afternoon') ?></option>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="form-group clockpicker">
                            <label for="time">
                                <?= \App\model\translation\Translation::get('formulier_tijdstip') ?>
                            </label>
                            <span style="color: red">*</span>
                            <input class="form-control" type="time" id="time" name="time" autocomplete="off" step="00:05"
                                   min="<?= $settings->get('schoolOpeningHour') ?>"
                                   value="<?= !empty($request->get('time')) ?
                                       parseToTimeInput($request->get('time')) : parseToTimeInput($date->toTimeString()) ?>"
                                   max="<?= $settings->get('schoolClosingHour') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="duration">
                                <?= \App\model\translation\Translation::get('formulier_duur') ?>
                            </label>
                            <span style="color: red">*</span>
                            <select class="form-control" id="duration" name="duration" required>
                                <option value="0.5" <?= floatval($request->get('duration')) ===
                                \App\model\reservation\Reservation::HALF_HOUR_OPTION ? 'selected' : '' ?>>
                                    <?= \App\model\translation\Translation::get('formulier_duur_optie_half_uur') ?>
                                </option>
                                <option value="1" <?= intval($request->get('duration')) ===
                                    \App\model\reservation\Reservation::ONE_HOUR_OPTION ? 'selected' : '' ?>>
                                    <?= \App\model\translation\Translation::get('formulier_duur_optie_uur') ?>
                                </option>
                                <option value="1.5" <?= floatval($request->get('duration')) ===
                                    \App\model\reservation\Reservation::ONE_AND_HALF_HOURS_OPTIONS ? 'selected' : '' ?>>
                                    <?= \App\model\translation\Translation::get('formulier_duur_optie_anderhalf_uur') ?>
                                </option>
                                <option value="2" <?= intval($request->get('duration')) ===
                                    \App\model\reservation\Reservation::TWO_HOURS_OPTION ? 'selected' : '' ?>>
                                    <?= \App\model\translation\Translation::get('formulier_duur_optie_2_uur') ?>
                                </option>
                            </select>
                        </div>
                    <?php endif; ?>

                    <button type="button" class="btn gray-bg text-white"
                            onclick="window.location.href='/werkplek/reserveren?kind=<?= $request->get('kind') ?>'">
                        <?= \App\model\translation\Translation::get('formulier_vorige_knop_tekst') ?>
                    </button>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\model\translation\Translation::get('formulier_volgende_knop_tekst') ?>
                    </button>
                </form>
            </div>
            <div class="col-sm-6 mb-1">
                <img class="mw-100" src="<?= loadImage($path ?? '',
                    '/resources/assets/images/map.svg') ?>"
                     alt=" <?= \App\model\translation\Translation::get('werkplek_resrveren_plattegrond_foto_alt_tekst') ?>">
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>