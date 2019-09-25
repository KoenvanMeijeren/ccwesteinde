<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
?>
    <img class="project-image desktop"
         width="100%"
         src="<?= loadImage($project->project_header_path ?? '', '/resources/assets/images/project_background.jpg') ?>"
         alt="<?= $project->project_title ?? '' ?>">

    <img class="project-image mobile"
         width="100%"
         height="300px"
         src="<?= loadImage($project->project_thumbnail_path ?? '', '/resources/assets/images/square_picture_project_background.jpg') ?>"
         alt="<?= $project->project_title ?? '' ?>">

    <div class="container page pt-0 mt-0">
        <div class="row">
            <div class="col-sm-12">
                <?= parseHTMLEntities($project->project_content ?? '') ?>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>