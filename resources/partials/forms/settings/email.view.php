<?php

use App\services\core\Translation;

$settings = new \App\model\admin\settings\Settings();
$request = new \App\services\core\Request();
?>
<div class="row mb-3">
    <p class="col-sm-12">
        Pas hier de toegestane email domeinen van studenten en docenten aan.
        Deze email domeinen worden gebruikt voor het registreren van studenten
        en inloggen van studenten en docenten.
    </p>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="student">
        <b><?= Translation::get('form_student_email') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="student" name="studentEmail" minlength="2" maxlength="100"
               value="<?= !empty($request->post('teacherEmail')) ? $request->post('teacherEmail') : $settings->get('studentEmail') ?>" required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="teacher">
        <b><?= Translation::get('form_teacher_email') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="teacher" name="teacherEmail" minlength="2" maxlength="100"
               value="<?= !empty($request->post('teacherEmail')) ? $request->post('teacherEmail') : $settings->get('teacherEmail') ?>" required>
    </div>
</div>
