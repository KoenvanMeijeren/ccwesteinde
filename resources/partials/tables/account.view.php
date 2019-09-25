<?php

use App\model\admin\account\User;
use App\services\core\Translation;
use App\services\helpers\Convert;

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
                    <th scope="row"><?= htmlspecialchars_decode($row['account_name'] ?? '-') ?></th>
                    <td><?= $row['account_email'] ?? '-' ?></td>
                    <td><?= Convert::rights($row['account_rights'] ?? 0) ?></td>
                    <td class="text-center">
                        <form method="post" action="/admin/account/<?= $row['account_ID'] ?? 0 ?>/unblock">
                            <button type="submit" class="btn btn-danger"
                                <?= ($user->getRights() >= 4) ? '' : 'disabled' ?>
                                <?= intval($row['account_is_blocked'] ?? 0) === 1 ? '' : 'disabled' ?>>
                                <?= Translation::get('unblock_button') ?>
                            </button>
                        </form>
                    </td>
                    <td class="text-center" width="10%">
                        <div class="pull-left">
                            <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('edit') ?>"
                                    onclick='window.location.href="/admin/account/<?= $row['account_ID'] ?? 0 ?>/edit"'
                                <?= ($user->getRights() >= 4) ? '' : 'disabled' ?>
                                <?= $user->getID() === intval($row['account_ID'] ?? 0) ? 'disabled' : '' ?>>
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                            </button>
                        </div>

                        <form class="pull-right" method="post" action="/admin/account/<?= $row['account_ID'] ?? 0 ?>/delete">
                            <button type="submit" class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                    title="<?= Translation::get('delete') ?>"
                                <?= ($user->getRights() >= 3) ? '' : 'disabled' ?>
                                <?= $user->getID() === intval(($row['account_ID'] ?? 0)) ? 'disabled' : '' ?>
                                    onclick="return confirm('<?= Translation::get('delete_account_confirmation_message') ?>')">
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
    <p><?= Translation::get('no_accounts_were_found_message') ?></p>
<?php endif; ?>