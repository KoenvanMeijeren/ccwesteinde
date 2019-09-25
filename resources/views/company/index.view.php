<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <div class="card h-100 green-bg clickable" onclick="window.location.href='/contact'">
                    <div class="card-body">
                        <div class="card-title mb-5">
                            <h1>
                                <?= \App\model\translation\Translation::get('call_to_action_bedrijf_contact_titel') ?>
                            </h1>
                            <p>
                                <?= \App\model\translation\Translation::get('call_to_action_bedrijf_contact_tekst') ?>
                            </p>
                        </div>

                        <button class="green-text" onclick="window.location.href='/contact'">
                            <?= \App\model\translation\Translation::get('call_to_action_bedrijf_contact_knop_tekst') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>