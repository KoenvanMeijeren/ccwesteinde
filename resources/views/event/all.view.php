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

        <?php if (isset($events) && !empty($events)) : ?>
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
        <?php endif; ?>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>