<?php use App\services\core\Translation;

loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title')); ?>
    <div style="width: 100%;" class="container page specialPadding" id="page">
        <div class="row mb-3">
            <div class="col-sm-11 m-auto specialPadding">
                <h3 class="float-left">Meet the Expert beheren</h3>

                <button type="button" class="btn default-bg text-white float-right"
                        onclick="window.location.href='/event/create'">
                    <?= \App\services\core\Translation::get('create_event_button') ?>
                </button>
            </div>

            <div class="col-sm-12 specialPadding">
                <?php
                loadFile(RESOURCES_PATH . '/partials/flash.view.php');

                loadTable('events',
                    [
                        \App\services\core\Translation::get('table_row_title'),
                        \App\services\core\Translation::get('table_row_thumbnail'),
                        \App\services\core\Translation::get('table_row_banner'),
                        \App\services\core\Translation::get('table_row_datetime'),
                        \App\services\core\Translation::get('table_row_location'),
                        \App\services\core\Translation::get('table_row_maximum_persons'),
                        \App\services\core\Translation::get('table_row_sign_ups'),
                        \App\services\core\Translation::get('table_row_edit')
                    ],
                    $events ?? []
                );
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-11 m-auto specialPadding">
                <h3>Gearchiveerde sessies</h3>
            </div>

            <div class="col-sm-12 specialPadding">
                <?php
                loadTable('archivedEvents',
                    [
                        \App\services\core\Translation::get('table_row_title'),
                        \App\services\core\Translation::get('table_row_thumbnail'),
                        \App\services\core\Translation::get('table_row_banner'),
                        \App\services\core\Translation::get('table_row_datetime'),
                        \App\services\core\Translation::get('table_row_location'),
                        \App\services\core\Translation::get('table_row_maximum_persons'),
                        \App\services\core\Translation::get('table_row_sign_ups'),
                        \App\services\core\Translation::get('table_row_edit')
                    ],
                    $archivedEvents ?? []
                );
                ?>
            </div>
        </div>
    </div>
<?php loadFile(RESOURCES_PATH . '/partials/footer.view.php'); ?>