<?php
$settings = new \App\model\admin\settings\Settings();
$page = new \App\model\admin\page\Page();
$pagesInFooter = $page->getAllByInMenu(4);
$pagesInFooter2 = $page->getAllByInMenu(5);

if ((!empty($pagesInFooter) && is_array($pagesInFooter)) || (!empty($pagesInFooter2) && is_array($pagesInFooter2))) {
    $pagesInFooter = array_merge($pagesInFooter, $pagesInFooter2);
}
?>

<!-- FOOTER -->
<footer>
    <div class="page mt-0 pt-0">
        <div class="row">
            <div class="col-sm-3 group">
                <div class="flex justify-content-start">
                    <a href="/projecten" class="link-unstyled">
                        <?= \App\model\translation\Translation::get('menu_item_projecten') ?>
                    </a>
                </div>
                <div class="flex justify-content-start">
                    <a href="/meet-the-expert" class="link-unstyled">
                        <?= \App\model\translation\Translation::get('menu_item_meet_the_expert') ?>
                    </a>
                </div>
                <div class="flex justify-content-start">
                    <a href="/contact" class="link-unstyled">
                        <?= \App\model\translation\Translation::get('menu_item_contact') ?>
                    </a>
                </div>
                <?php if (!empty($pagesInFooter) && is_array($pagesInFooter)) :
                    foreach ($pagesInFooter as $singlePage) : ?>
                        <div class="flex justify-content-start">
                            <a href="/<?= $singlePage['page_slug_name'] ?? '#' ?>" class="link-unstyled">
                                <?= htmlspecialchars_decode($singlePage['page_title'] ?? '') ?>
                            </a>
                        </div>
                    <?php endforeach;
                endif; ?>
            </div>
            <div class="col-sm-3 group">
                <?php if (!empty($settings->get('facebook'))) : ?>
                    <div class="flex justify-content-start">
                        <a target="_blank" rel="noopener nofollow" href="<?= $settings->get('facebook') ?>"
                           class="link-unstyled">Facebook</a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($settings->get('instagram'))) : ?>
                    <div class="flex justify-content-start">
                        <a target="_blank" rel="noopener nofollow" href="<?= $settings->get('instagram') ?>"
                           class="link-unstyled">Instagram</a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($settings->get('twitter'))) : ?>
                    <div class="flex justify-content-start">
                        <a target="_blank" rel="noopener nofollow" href="<?= $settings->get('twitter') ?>"
                           class="link-unstyled">Twitter</a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($settings->get('linkedin'))) : ?>
                    <div class="flex justify-content-start">
                        <a target="_blank" rel="noopener nofollow" href="<?= $settings->get('linkedin') ?>"
                           class="link-unstyled">LinkedIn</a>
                    </div>
                <?php endif; ?>
                <?php if (!empty($settings->get('youtube'))) : ?>
                    <div class="flex justify-content-start">
                        <a target="_blank" rel="noopener nofollow" href="<?= $settings->get('youtube') ?>"
                           class="link-unstyled">Youtube</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-sm-3 group">
                <div class="flex justify-content-start">
                    <?= $settings->get('companyName') ?>
                </div>
                <div class="flex justify-content-start">
                    <?= $settings->get('companyAddress') ?>
                </div>
                <div class="flex justify-content-start">
                    <?= $settings->get('companyPostcode') ?>
                    <?= $settings->get('companyCity') ?>
                </div>
                <div class="flex justify-content-start">
                    Tel: <?= str_replace('mailto', 'tel', obfuscate_email($settings->get('companyTel'))) ?>
                </div>
                <div class="flex justify-content-start">
                    Email: <?= obfuscate_email($settings->get('companyEmail')) ?>
                </div>
            </div>
            <div class="col-sm-3 group">
                <img class="footer-logo w-100 text-center" src="/resources/assets/images/landstede_logo.svg"
                     alt="Landstede Logo">
            </div>
        </div>
    </div>
</footer>

<!-- FRAMEWORKS -->
<script src="/resources/assets/plugin-frameworks/jquery-3.2.1.min.js"></script>
<script src="/resources/assets/admin/vendor/bootstrap-4.1/popper.min.js"></script>
<script src="/resources/assets/plugin-frameworks/bootstrap.min.js"></script>
<script src="/resources/assets/plugin-frameworks/swiper.js"></script>

<?php if (strstr(\App\services\core\URL::getUrl(), 'contact') !== false) : ?>
    <!-- External -->
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
<?php endif; ?>

<!-- Date and time picker -->
<script src="/resources/assets/js/bootstrap-datepicker.js"></script>
<script src="/resources/assets/js/locales/bootstrap-datepicker.nl.min.js"></script>
<script src="/resources/assets/plugin-frameworks/clockpicker-gh-pages/dist/jquery-clockpicker.min.js"></script>
<script src="/resources/assets/plugin-frameworks/clockpicker-gh-pages/src/clockpicker.js"></script>

<?php if (strstr(\App\services\core\URL::getUrl(), 'events') !== false ||
    strstr(\App\services\core\URL::getUrl(), 'event') !== false) : ?>
    <!-- Data tables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.semanticui.min.js"></script>
    <script src="/resources/assets/admin/js/addons/datatables.js"></script>
    <script src="/resources/assets/admin/js/addons/datatables-select.js"></script>
    <script src="/resources/assets/js/datatables.js"></script>

    <!-- Cropper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.1/cropper.min.js"></script>
    <script src="/resources/assets/js/cropperjs.js"></script>

    <!-- Tiny MCE -->
    <script src='https://cloud.tinymce.com/5/tinymce.min.js?apiKey=<?= \App\services\core\Config::get('tinyMceKey') ?>'></script>
    <script src="/resources/assets/admin/js/tinymce.js"></script>
<?php endif; ?>

<!-- Main -->
<script src="/resources/assets/js/functions.js"></script>

</body>
</html>