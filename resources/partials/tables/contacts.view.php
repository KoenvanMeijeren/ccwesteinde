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
                    <th scope="row"><?= htmlspecialchars_decode($row->branch_name ?? '-') ?></th>
                    <td><?= htmlspecialchars_decode($row->landscape_name ?? '-') ?></td>
                    <td><?= htmlspecialchars_decode($row->contact_name ?? '-') ?></td>
                    <td><?= htmlspecialchars_decode($row->contact_email ?? '-') ?></td>
                    <td class="text-center" width="10%">
                        <div class="pull-left">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('edit') ?>"
                                    onclick='window.location.href="/admin/contact/<?= $row->contact_ID ?? 0 ?>/edit"'>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </div>

                        <form class="pull-right" method="post" action="/admin/contact/<?= $row->contact_ID ?? 0 ?>/delete">
                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('delete') ?>"
                                    onclick="return confirm('<?= Translation::get('delete_contact_confirmation_message') ?>')">
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
    <p><?= Translation::get('no_contacts_were_found_message') ?></p>
<?php endif; ?>