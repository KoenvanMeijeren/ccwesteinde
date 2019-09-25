<?php if (isset($projects) && !empty($projects)) : ?>
    <div id="carouselMobile" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php $active = 'active';
            foreach ($projects as $project) : ?>
                <div class="carousel-item clickable <?= $active ?>"
                     onclick="window.location.href='/projecten'">
                    <img class="d-block w-100 carousel-image"
                         width="100%" height="300px"
                         src="<?= loadImage($project->project_thumbnail_path ?? '',
                             '/resources/assets/images/square_picture_project_background.jpg') ?>"
                         alt="<?= $project->project_title ?>">
                </div>
                <?php $active = '';
            endforeach; ?>
        </div>

        <button class="project-button gray-text" onclick="window.location.href='/projecten'">
            <?= \App\model\translation\Translation::get('projecten_bekijken_knop_tekst') ?>
        </button>

        <img class="project_text_image" src="/resources/assets/images/project_text.svg"
             alt="<?= \App\model\translation\Translation::get('projecten_foto_alt_tekst') ?>">
    </div>
<?php endif; ?>