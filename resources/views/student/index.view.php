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
            <div class="col-sm-6 mb-2 border-right student-card">
                <div class="card green-bg clickable" onclick="window.location.href='/werkplek/reserveren'">
                    <div class="card-body">
                        <div class="card-title h-50 mb-5">
                            <h1>
                                <?= \App\model\translation\Translation::get('call_to_action_werkplek_titel') ?>
                            </h1>
                            <p>
                                <?= \App\model\translation\Translation::get('call_to_action_werkplek_tekst') ?>
                            </p>
                        </div>

                        <button class="green-text" onclick="window.location.href='/werkplek/reserveren'">
                            <?= \App\model\translation\Translation::get('call_to_action_werkplek_knop_tekst') ?>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 student-card">
                <div class="card green-bg clickable" onclick="window.location.href='/meet-the-experts'">
                    <div class="card-body">
                        <div class="card-title h-50 mb-5">
                            <h1>
                                <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_aanmelden_titel') ?>
                            </h1>
                            <p>
                                <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_aanmelden_tekst') ?>
                            </p>
                        </div>

                        <button class="green-text" onclick="window.location.href='/meet-the-experts'">
                            <?= \App\model\translation\Translation::get('call_to_action_meet_the_expert_aanmelden_knop_tekst') ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>