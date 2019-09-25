<?php

use App\services\core\Translation;

$settings = new \App\model\admin\settings\Settings();
$request = new \App\services\core\Request();
?>
<div class="row mb-3">
    <p class="col-sm-12">
        Upload hier een plattegrond of pas de openingstijden aan van <?= $settings->get('companyName') ?>.
        Deze plattegrond wordt getoond naast het formulier voor het
        reserveren van werkplekken en vergaderruimtes.
    </p>
</div>

<div class="row form-group">
    <label class="col-sm-2" for="workspace">
        <b><?= Translation::get('form_map') ?><br><?= $settings->get('companyName') ?></b>
        <?= !empty($settings->get('workspace_image')) ? '' : '<span style="color: red">*</span>' ?>
    </label>

    <?php if (!empty($settings->get('workspace_image'))) : ?>
        <div class="col-sm-4">
            <h5>Huidige foto</h5>
            <img src="<?= $settings->get('workspace_image') ?>" alt="<?= Translation::get('form_map') ?>">
        </div>
        <div class="col-sm-4">
            <h5>Nieuwe foto (optioneel)</h5>
            <input class="form-control form-control-file" id="workspace" name="workspace_image"
                   type="file">
        </div>
    <?php else : ?>
        <input class="form-control form-control-file col-sm-10" id="workspace" name="workspace_image"
               type="file" required>
    <?php endif; ?>
</div>

<div class="row form-group">
    <label for="time" class="col-sm-2">
        <b><?= Translation::get('form_opening_hour') ?></b><span style="color: red">*</span>
    </label>

    <input class="form-control col-sm-10" type="time" id="time" name="schoolOpeningHour" autocomplete="off"
           value="<?= !empty($request->post('schoolOpeningHour')) ? $request->post('schoolOpeningHour') :
           $settings->get('schoolOpeningHour') ?>" required>
</div>

<div class="row form-group">
    <label for="time1" class="col-sm-2">
        <b><?= Translation::get('form_closing_hour') ?></b><span style="color: red">*</span>
    </label>

    <input class="form-control col-sm-10" type="time" id="time1" name="schoolClosingHour" autocomplete="off"
           value="<?= !empty($request->post('schoolClosingHour')) ? $request->post('schoolClosingHour') :
               $settings->get('schoolClosingHour') ?>" required>
</div>
