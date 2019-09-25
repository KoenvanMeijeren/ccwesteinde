<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>