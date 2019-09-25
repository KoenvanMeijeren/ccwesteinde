<?php if (isset($projects) && !empty($projects)) : ?>
    <div class="carousel slide" data-ride="carousel">
        <div class="carousel-inner clickable">
            <?php $active = 'active';
            foreach ($projects as $project) : ?>
                <div class="carousel-item clickable <?= $active ?>"
                     onclick="window.location.href='/projecten'">
                    <img class="d-block w-100 carousel-image"
                         width="100%"
                         height="250px"
                         src="
                         <?= loadImage($project->project_banner_path ?? '',
                             '/resources/assets/images/project_background.jpg') ?>"
                         alt="<?= $project->project_title ?>">
                </div>
                <?php $active = '';
            endforeach; ?>
        </div>

        <button class="project-button gray-text" onclick="window.location.href='/projecten'">
            <?= \App\model\translation\Translation::get('project_bekijken_knop_tekst') ?>
        </button>

        <img class="project_text_image" src="/resources/assets/images/project_text.svg"
             alt="<?= \App\model\translation\Translation::get('projecten_foto_alt_tekst') ?>">
    </div>
<?php endif; ?>