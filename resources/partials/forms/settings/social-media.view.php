<?php

use App\services\core\Translation;

$settings = new \App\model\admin\settings\Settings();
$request = new \App\services\core\Request();
?>
<div class="row mb-3">
    <p class="col-sm-12">
        Bewerk hier de sociale media accounts. Wanneer je een veld leeg laat wordt deze niet getoond op de website.
    </p>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-facebook">
        <b><?= Translation::get('form_social_facebook') ?></b>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-facebook" name="facebook"
               value="<?= !empty($request->post('facebook')) ? $request->post('facebook') :  $settings->get('facebook') ?>">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-instagram">
        <b><?= Translation::get('form_social_instagram') ?></b>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-instagram" name="instagram"
               value="<?= !empty($request->post('instagram')) ? $request->post('instagram') : $settings->get('instagram') ?>">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-linkedin">
        <b><?= Translation::get('form_social_linkedIn') ?></b>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-linkedin" name="linkedin"
               value="<?= !empty($request->post('linkedin')) ? $request->post('linkedin') : $settings->get('linkedin') ?>">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-youtube">
        <b><?= Translation::get('form_social_youtube') ?></b>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-youtube" name="youtube"
               value="<?= !empty($request->post('youtube')) ? $request->post('youtube') : $settings->get('youtube') ?>">
    </div>
</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label" for="social-media-twitter">
        <b><?= Translation::get('form_social_twitter') ?></b>
    </label>

    <div class="col-sm-10">
        <input class="form-control" type="url" id="social-media-twitter" name="twitter"
               value="<?= !empty($request->post('twitter')) ? $request->post('twitter') : $settings->get('twitter') ?>">
    </div>
</div>