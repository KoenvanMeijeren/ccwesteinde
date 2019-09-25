<?php

use App\model\admin\account\User;
use App\services\core\Translation;

$user = new User();
$request = new \App\services\core\Request();
if (isset($keys) && !empty($keys) && isset($rows) && !empty($rows)) : ?>
    <form method="post" action="/admin/translation/update">
        <?= \App\services\security\CSRF::formToken('/admin/translation/update') ?>
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
                        <td width="50%">
                            <?= $row['translation_name'] ?? '' ?>
                        </td>
                        <td width="50%">
                            <input style="width: 95%" type="text" class="form-control" id="value"
                                   name="<?= $row['translation_name'] ?? '' ?>" required
                                   value="<?= !empty($request->post($row['translation_name'] ?? '')) ?
                                       parseHTMLEntities($request->post($row['translation_name'] ?? '')) :
                                       parseHTMLEntities($row['translation_value'] ?? '') ?>"
                                   placeholder="<?= \App\services\core\Translation::get('form_translation_value') ?>">
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>
                        <button type="submit" class="btn default"
                            <?= $user->getRights() >= 3 ? '' : 'disabled' ?>>
                            <?= \App\services\core\Translation::get('save_button') ?>
                        </button>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </form>
<?php else : ?>
    <p><?= Translation::get('no_translations_were_found_message') ?></p>
<?php endif; ?>