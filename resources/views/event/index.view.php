<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
?>
    <div class="container page" id="page">
        <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php') ?>

        <div class="row">
            <div class="col-sm-11 m-auto">
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>
        </div>

        <?php if (isset($events) && !empty($events) && is_array($events)) : ?>
            <div class="row mb-2">
                <h3 class="m-auto">
                    <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_aanmelden_overzicht_titel') ?>
                </h3>
            </div>

            <div class="row">
                <?php foreach ($events as $event) : ?>
                    <div class="col-sm-6 w-100 border-right clickable"
                         onclick="window.location.href='/meet-the-expert/<?= $event->event_ID ?? 0 ?>'">
                        <img class="card-img-top" width="100%" height="300px"
                             src="<?= loadImage($event->thumbnail_path ?? '',
                                 '/resources/assets/images/square_picture_project_background.jpg') ?>"
                             alt="<?= $event->event_title ?? '' ?>">
                        <h4 class="p-1 project_text green-bg text-white"><?= ucfirst($event->event_title ?? '') ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($events) >= 4) : ?>
                <div class="row">
                    <button type="button" class="green-bg text-white mt-2 mb-2 ml-auto mr-auto"
                            onclick="window.location.href='/meet-the-experts'">
                        <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_bekijk_alles_knop_tekst') ?>
                    </button>
                </div>
            <?php endif;
        endif; ?>

        <?php if (isset($archivedEvents) && !empty($archivedEvents) && is_array($archivedEvents)) : ?>
            <div class="row mb-2">
                <h3 class="m-auto">
                    <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_archief_overzicht_titel') ?>
                </h3>
            </div>

            <div class="row mt-2">
                <?php foreach ($archivedEvents as $archivedEvent) : ?>
                    <div class="col-sm-6 w-100 border-right clickable"
                         onclick="window.location.href='/meet-the-expert/<?= $archivedEvent->event_ID ?? 0 ?>'">
                        <img class="card-img-top" width="100%" height="300px"
                             src="<?= loadImage($archivedEvent->thumbnail_path ?? '',
                                 '/resources/assets/images/square_picture_project_background.jpg') ?>"
                             alt="<?= $archivedEvent->event_title ?? '' ?>">
                        <h4 class="p-1 project_text green-bg text-white"><?= $archivedEvent->event_title ?? '' ?></h4>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (count($archivedEvents) >= 4) : ?>
                <div class="row">
                    <button type="button" class="green-bg text-white mt-2 mb-2 ml-auto mr-auto"
                            onclick="window.location.href='/meet-the-experts/archief'">
                        <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_bekijk_alles_knop_tekst') ?>
                    </button>
                </div>
            <?php endif;
        endif; ?>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>