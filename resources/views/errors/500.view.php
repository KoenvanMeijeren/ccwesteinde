<?php
$title = 'Interne server error';
loadFile(RESOURCES_PATH . '/partials/errors/header.view.php', compact('title'));

use App\services\core\Translation;

?>
    <div class="container page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <h1><span>500</span><?= Translation::get('internal_server_error_title') ?></h1>
                <p><?= Translation::get('internal_server_error_description') ?></p>
            </div>
        </div>
    </div>

<?php loadFile(RESOURCES_PATH . '/partials/errors/footer.view.php');
exit(500); ?>