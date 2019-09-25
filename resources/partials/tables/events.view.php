<?php

use App\model\admin\account\User;
use App\services\core\Translation;

$user = new User();
if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <div class="table-responsive">
        <table id="table" class="table table-light table-hover table-striped text-nowrap">
            <thead>
            <tr>
                <?php foreach ($keys as $key) : ?>
                    <th class="th-sm" scope="col">
                        <?= $key ?? '' ?>
                    </th>
                <?php endforeach; ?>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <th scope="row"><?= htmlspecialchars_decode(ucfirst($row->event_title ?? '-')) ?></th>
                    <td><img src="<?= $row->thumbnail_path ?? '' ?>" alt="Thumbnail foto" width="100px"></td>
                    <td><img src="<?= $row->banner_path ?? '' ?>" alt="Banner foto" width="100px"></td>
                    <td>
                        Datum: <?= parseToDate($row->event_start_datetime ?? '') ?><br>
                        Begin tijd: <?= parseToTime($row->event_start_datetime ?? '') ?><br>
                        Eind tijd: <?= parseToTime($row->event_end_datetime ?? '') ?><br>
                    </td>
                    <td><?= htmlspecialchars_decode(ucfirst($row->event_location ?? '-')) ?></td>
                    <td><?= intval($row->event_maximum_persons ?? 0) ?></td>
                    <td><?= intval($row->quantitySignUps ?? 0) ?></td>
                    <td>
                        <div class="row">
                            <form class="m-1" method="post" action="event/<?= $row->event_ID ?? 0 ?>/archive">
                                <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="top"
                                        title="<?= Translation::get('archive') ?>"
                                        onclick="return confirm('<?= Translation::get('archive_event_confirmation_message') ?>')">
                                    <i class="fa fa-file-archive" aria-hidden="true"></i>
                                </button>
                            </form>

                            <form class="m-1">
                                <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                        title="<?= Translation::get('edit') ?>"
                                        onclick='window.location.href="event/<?= $row->event_ID ?? 0 ?>/edit"'>
                                    <i class="fa fa-edit"></i>
                                </button>
                            </form>

                            <form class="m-1" method="post" action="event/<?= $row->event_ID ?? 0 ?>/delete">
                                <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                        title="<?= Translation::get('delete') ?>"
                                        onclick="return confirm('<?= Translation::get('delete_event_confirmation_message') ?>')">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p><?= Translation::get('no_events_were_found_message') ?></p>
<?php endif; ?>