<?php loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div class="container page" id="page">
        <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>

        <div class="row mb-3">
            <?php loadFile(RESOURCES_PATH . '/views/home/about_ccwesteinde.view.php', compact('page')) ?>
        </div>

        <div class="row desktop mb-1">
            <?php loadFile(RESOURCES_PATH . '/views/home/call_to_action.view.php') ?>
        </div>

        <div class="row mobile mb-1">
            <div class="col-sm-12">
                <?php loadFile(RESOURCES_PATH . '/views/home/call_to_action.view.php') ?>
            </div>
        </div>

        <?php if (isset($projects) && !empty($projects)) : ?>
            <div class="row desktop">
                <?php loadFile(RESOURCES_PATH . '/views/home/carousel.view.php', compact('projects')) ?>
            </div>
        <?php endif; ?>

        <?php if (isset($projects) && !empty($projects)) : ?>
            <div class="row mobile">
                <div class="col-sm-12">
                    <?php loadFile(RESOURCES_PATH . '/views/home/mobile-carousel.view.php', compact('projects')) ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>