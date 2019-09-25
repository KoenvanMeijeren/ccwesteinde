<?php

use App\services\core\Translation;

$settings = new \App\model\admin\settings\Settings();
$request = new \App\services\core\Request();
?>
<div class="row mb-3">
    <p class="col-sm-12">
        Bewerk hier de instellingen over het bedrijf. Deze gegegevens worden gebruikt in de footer van de website.
    </p>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-name">
        <b><?= Translation::get('form_name') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-name" name="companyName" minlength="2" maxlength="100"
               value="<?= !empty($request->post('companyName')) ? $request->post('companyName') : $settings->get('companyName') ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-tel">
        <b><?= Translation::get('form_phone') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="tel" id="company-tel" name="companyTel" minlength="10" maxlength="14"
               value="<?= !empty($request->post('companyTel')) ? $request->post('companyTel') : $settings->get('companyTel') ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-email">
        <b><?= Translation::get('form_email') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-email" name="companyEmail" minlength="2" maxlength="100"
               value="<?= !empty($request->post('companyEmail')) ? $request->post('companyEmail') : $settings->get('companyEmail') ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-address">
        <b><?= Translation::get('form_address') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-address" name="companyAddress" minlength="2" maxlength="100"
               value="<?= !empty($request->post('companyAddress')) ? $request->post('companyAddress') : $settings->get('companyAddress') ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-postcode">
        <b><?= Translation::get('form_postal') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-postcode" name="companyPostcode" minlength="5" maxlength="6"
               value="<?= !empty($request->post('companyPostcode')) ? $request->post('companyPostcode') : $settings->get('companyPostcode') ?>"
               required>
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="company-city">
        <b><?= Translation::get('form_city') ?></b><span style="color: red">*</span>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="text" id="company-city" name="companyCity" minlength="2" maxlength="100"
               value="<?= !empty($request->post('companyCity')) ? $request->post('companyCity') : $settings->get('companyCity') ?>"
               required>
    </div>
</div>
