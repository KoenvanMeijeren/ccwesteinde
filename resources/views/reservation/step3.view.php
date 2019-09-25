<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));

$request = new \App\services\core\Request();
$reservation = new \App\model\reservation\Reservation();
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <h3><?= $title ?? '' ?></h3>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-1 border-right">
                <form method="post" action="/werkplek/reserveren">
                    <?= \App\services\security\CSRF::formToken('/werkplek/reserveren') ?>

                    <input type="hidden" name="kind" value="<?= $request->get('kind') ?>">
                    <input type="hidden" name="date" value="<?= $request->get('date') ?>">
                    <input type="hidden" name="time" value="<?= $request->get('time') ?>">
                    <input type="hidden" name="dayPart" value="<?= $request->get('dayPart') ?>">
                    <input type="hidden" name="duration" value="<?= $request->get('duration') ?>">

                    <?php if (intval($request->get('kind')) === 9) : ?>
                        <div class="form-group">
                            <label for="workspace">
                                <?= ucfirst(\App\model\translation\Translation::get('formulier_werkplek')) ?>
                            </label>
                            <span style="color: red">*</span>
                            <select id="workspace" class="form-control" name="workspace" required>
                                <?php if (isset($workspaces) && !empty($workspaces) && is_array($workspaces)) :
                                    foreach ($workspaces as $workspace) :
                                        $reservedCheck1 = $reservation->getByWorkspaceAndDateTime($workspace->workspace_ID ?? 0);
                                        $reservedCheck2 = $reservation->getByWorkspaceInBetweenStartOrEndDateTime($workspace->workspace_ID ?? 0); ?>
                                        <option value="<?= $workspace->workspace_ID ?? 0 ?>"
                                            <?= !empty($reservedCheck1) || !empty($reservedCheck2) ? 'disabled' : '' ?>
                                            <?= intval($request->get('workspace')) === (intval($workspace->workspace_ID ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars_decode(ucfirst($workspace->workspace_name ?? '')) ?>
                                            <?= !empty($reservedCheck1->account_email ?? '') ? ' - bezet door ' . $reservedCheck1->account_email ?? '' :
                                                !empty($reservedCheck2->account_email ?? '') ? ' - bezet door ' . $reservedCheck2->account_email ?? '' : '' ?>
                                        </option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for="meeting_room">
                                <?= ucfirst(\App\services\core\Translation::get('form_meeting_room')) ?>
                            </label>
                            <span style="color: red">*</span>
                            <select id="meeting_room" class="form-control" name="workspace" required>
                                <?php if (isset($workspaces) && !empty($workspaces) && is_array($workspaces)) :
                                    foreach ($workspaces as $workspace) :
                                        $reservedCheck1 = $reservation->getByWorkspaceAndDateTime($workspace->workspace_ID ?? 0);
                                        $reservedCheck2 = $reservation->getByWorkspaceInBetweenStartOrEndDateTime($workspace->workspace_ID ?? 0);
                                        $reservedCheck3 = $reservation->checkIfThereIsAOtherReservationBetweenTheCurrentDate($workspace->workspace_ID ?? 0); ?>
                                        <option value="<?= $workspace->workspace_ID ?? 0 ?>"
                                            <?= !empty($reservedCheck1) || !empty($reservedCheck2) || !empty($reservedCheck3) ? 'disabled' : '' ?>
                                            <?= intval($request->get('workspace')) === (intval($workspace->workspace_ID ?? 0)) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars_decode(ucfirst($workspace->workspace_name ?? '')) ?>
                                            <?= !empty($reservedCheck1->account_email ?? '') ? ' - bezet door ' . $reservedCheck1->account_email ?? '' :
                                                !empty($reservedCheck2->account_email ?? '') ? ' - bezet door ' . $reservedCheck2->account_email ?? '' :
                                                !empty($reservedCheck3->account_email ?? '') ? ' - bezet door ' . $reservedCheck3->account_email ?? '' : '' ?>
                                        </option>
                                    <?php endforeach;
                                endif; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <button type="button" class="btn gray-bg text-white"
                            onclick="window.location.href='/werkplek/reserveren/stap-2?time=<?= $request->get('time') ?>&date=<?= $request->get('date') ?>&duration=<?= $request->get('duration') ?>&kind=<?= $request->get('kind') ?>&dayPart=<?= $request->get('dayPart') ?>'">
                        <?= \App\model\translation\Translation::get('formulier_vorige_knop_tekst') ?>
                    </button>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\model\translation\Translation::get('formulier_reserveren_knop_tekst') ?>
                    </button>
                </form>
            </div>
            <div class="col-sm-6 mb-1">
                <img class="mw-100" src="<?= loadImage($path ?? '',
                    '/resources/assets/images/map.svg') ?>"
                     alt=" <?= \App\model\translation\Translation::get('werkplek_reserveren_plattegrond_foto_alt_tekst') ?>">
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>