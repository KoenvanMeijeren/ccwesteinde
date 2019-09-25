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
                    <th scope="row"><?= htmlspecialchars_decode($row->project_title ?? '-') ?></th>
                    <td><img src="<?= $row->project_thumbnail_path ?? '' ?>" alt="Thumbnail foto" width="100px"></td>
                    <td><img src="<?= $row->project_banner_path ?? '' ?>" alt="Banner foto" width="100px"></td>
                    <td><img src="<?= $row->project_header_path ?? '' ?>" alt="Header foto" width="100px"></td>
                    <td class="text-center" width="10%">
                        <div class="pull-left">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('edit') ?>"
                                    onclick='window.location.href="/admin/project/<?= $row->project_ID ?? 0 ?>/edit"'>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </div>

                        <form class="pull-right" method="post" action="/admin/project/<?= $row->project_ID ?? 0 ?>/delete">
                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('delete') ?>"
                                <?= intval($row->project_in_menu ?? 0) === 2 ? 'disabled' : '' ?>
                                    onclick="return confirm('<?= Translation::get('delete_project_confirmation_message') ?>')">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else : ?>
    <p><?= Translation::get('no_projects_were_found_message') ?></p>
<?php endif; ?>