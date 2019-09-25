<?php
loadFile(RESOURCES_PATH . '/partials/header.view.php', compact('title'));
$request = new \App\services\core\Request();
$user = new \App\model\admin\account\User();
?>
    <div class="container page" id="page">
        <div class="row">
            <div class="col-sm-11 m-auto">
                <?php loadFile(RESOURCES_PATH . '/partials/flash.view.php'); ?>
                <?= parseHTMLEntities($page->page_content ?? '') ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 mb-1 border-right">
                <form method="get" action="/werkplek/reserveren/stap-2">
                    <div class="form-group">
                        <label for="kind">
                            <?= \App\model\translation\Translation::get('formulier_welke_werkplek_reserveren_kiezen_tekst') ?>
                        </label><span style="color: red">*</span>

                        <select class="form-control" id="kind" name="kind" required>
                            <?php if (isset($workspaces) && !empty($workspaces) && is_array($workspaces)) :
                                foreach ($workspaces as $workspace) : ?>
                                    <option value="<?= $workspace->workspace_slug_ID ?? 0 ?>"
                                        <?= intval($request->get('kind')) === (intval($workspace->workspace_slug_ID ?? 0)) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars_decode(ucfirst($workspace->slug_name ?? '')) ?>
                                    </option>
                                <?php endforeach;
                            endif; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn green-bg text-white">
                        <?= \App\model\translation\Translation::get('formulier_volgende_knop_tekst') ?>
                    </button>
                </form>
            </div>
            <div class="col-sm-6 mb-1">
                <img class="mw-100" src="<?= loadImage($path ?? '',
                    '/resources/assets/images/map.svg') ?>"
                     alt=" <?= \App\model\translation\Translation::get('werkplek_reserveren_plattegrond_foto_alt_tekst') ?>">
            </div>
        </div>
    </div>
<?php
loadFile(RESOURCES_PATH . '/partials/footer.view.php');
?>