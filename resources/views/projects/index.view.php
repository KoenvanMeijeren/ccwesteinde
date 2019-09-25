<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
?>
    <div class="container page" id="page">
        <div class="row mb-1">
            <div class="col-sm-11 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>
        </div>

        <div class="row mb-1">
            <?php if (isset($projects) && !empty($projects) && is_array($projects)) :
                foreach ($projects as $project) : ?>
                <div class="col-sm-6 border-right clickable" onclick="window.location.href='/projecten/<?= $project->project_ID ?? 0 ?>'">
                    <img class="card-img-top" width="100%" height="300px"
                         src="<?= loadImage($project->project_thumbnail_path ?? '',
                             '/resources/assets/images/square_picture_project_background.jpg') ?>"
                         alt="<?= $project->project_title ?? '' ?>">
                    <h4 class="p-1 project_text green-bg text-white"><?= $project->project_title ?? '' ?></h4>
                </div>
                <?php endforeach;
            else :
                echo \App\services\core\Translation::get('no_projects_were_found');
            endif; ?>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>