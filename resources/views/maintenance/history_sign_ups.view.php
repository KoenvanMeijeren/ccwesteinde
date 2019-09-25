<?php use App\services\core\Translation;

$signUpPerEvent = new \App\model\signUp\SignUp();
$request = new \App\services\core\Request();
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-9 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <h3>De historie van Meet the Expert</h3>
                <p>
                    Een overzicht van alle aanmeldingen. De getallen naast een sessie geven de bezettingsgraad weer.
                    Ze worden als volgt getoond: <b>(aantal aanmeldingen) - (aantal resterende plekken)</b>
                </p>
            </div>

            <div class="col-sm-2">
                <button type="button" class="btn default-bg text-white float-right"
                    onclick="window.location.href='/aanmeldingen/beheren?limit=100'">
                    Aanmeldingen beheren
                </button>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-sm-11 m-auto">
                <form method="get" class="form-inline">
                    <div class="form-group">
                        <label for="limit" class="mr-2"><?= Translation::get('filter_records') ?></label>
                        <input type="number" min="1" step="1" name="limit" id="limit" class="form-control"
                               value="<?= !empty(intval($request->get('limit'))) ? intval($request->get('limit')) : 0 ?>">
                    </div>

                    <button type="submit" class="btn default-bg text-white ml-2">
                        <?= Translation::get('event_button') ?>
                    </button>
                </form>
            </div>
        </div>

        <div class="row mb-5">
            <?php if (isset($signUps) && !empty($signUps) && is_array($signUps)) : ?>
                <div class="col-sm-4">
                    <div class="list-group" id="list-tab" role="tablist">
                        <?php
                        $active = 'active';
                        foreach ($signUps as $signUp) :
                            $signUpsPerEvent = $signUpPerEvent->getAllPerEvent($signUp->signUp_event_ID ?? 0); ?>
                            <a class="list-group-item list-group-item-action <?= $active ?>"
                               id="list-<?= $signUp->signUp_event_ID ?? 0 ?>-list"
                               data-toggle="list" href="#list-<?= $signUp->signUp_event_ID ?? 0 ?>" role="tab"
                               aria-controls="<?= $signUp->signUp_event_ID ?? 0 ?>">
                                <?= ucfirst($signUp->signUp_event_title ?? '') ?>

                                <span class="badge green-bg text-white badge-pill float-right">
                                    <?= count($signUpsPerEvent) ?> -
                                    <?php $remaining = intval($signUp->signUp_event_maximum_persons ?? 0) - count($signUpsPerEvent); ?>
                                    <?= number_format($remaining, 0) ?>
                                </span>
                            </a>
                            <?php
                            $active = '';
                        endforeach; ?>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="tab-content" id="nav-tabContent">
                        <?php $active = 'active';
                        $show = 'show';
                        foreach ($signUps as $signUp) :
                            $signUpsPerEvent = $signUpPerEvent->getAllPerEvent($signUp->signUp_event_ID ?? 0); ?>
                            <div class="tab-pane fade <?= $show ?> <?= $active ?>"
                                 id="list-<?= $signUp->signUp_event_ID ?? 0 ?>" role="tabpanel"
                                 aria-labelledby="list-<?= $signUp->signUp_event_ID ?? 0 ?>-list">
                                <div id="workspaces" class="ml-3 mt-3">
                                    <h3><?= ucfirst($signUp->signUp_event_title ?? '') ?></h3>
                                    <p>
                                        Locatie: <?= $signUp->signUp_event_location ?? '' ?><br>
                                        Datum: <?= parseToDate($signUp->signUp_event_start_datetime ?? '') ?><br>
                                        Begin tijd: <?= parseToTime($signUp->signUp_event_start_datetime ?? '') ?><br>
                                        Eind tijd: <?= parseToTime($signUp->signUp_event_end_datetime ?? '') ?><br>
                                        Aantal plekken: <?= intval($signUp->signUp_event_maximum_persons ?? 0) ?><br>
                                        Aantal beschikbare
                                        plekken: <?= intval($signUp->signUp_event_maximum_persons ?? 0) - intval(count($signUpsPerEvent)) ?>
                                        <br>

                                        <?php
                                        $divisions = count($signUpsPerEvent) / intval($signUp->signUp_event_maximum_persons ?? 0);
                                        ?>
                                        Percentage aanmeldingen: <?= number_format($divisions * 100, 0) . '%' ?>
                                    </p>

                                    <h3>Aanmeldingen:</h3>
                                    <ul class="list-group list-group-flush">
                                        <?php if (!empty($signUpsPerEvent) && is_array($signUpsPerEvent)) :
                                            foreach ($signUpsPerEvent as $singleSignUp) : ?>
                                                <li class="list-group-item">
                                                    Naam: <?= $singleSignUp->signUp_user_name ?? '' ?><br>
                                                    Email: <?= $singleSignUp->signUp_user_email ?? '' ?><br>
                                                    Opleiding: <?= $singleSignUp->signUp_user_education ?? '' ?>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            Er zijn geen aanmeldingen gevonden
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <?php $active = '';
                            $show = '';
                        endforeach; ?>
                    </div>
                </div>
            <?php else : ?>
                Er zijn geen aanmeldingen gevonden.
            <?php endif; ?>
        </div>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>