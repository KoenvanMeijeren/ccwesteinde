<?php

use App\services\core\URL;

$user = new \App\model\admin\account\User();
$page = new \App\model\admin\page\Page();
$request = new \App\services\core\Request();
$pagesPublic = $page->getAllByInMenu(1);
$pagesLoggedIn = $page->getAllByInMenu(2);
$pagesInFooterAndMenu = $page->getAllByInMenu(5);
if ((!empty($pagesInFooterAndMenu) && is_array($pagesInFooterAndMenu)) ||
    (!empty($pagesPublic) && is_array($pagesPublic))
) {
    $pagesPublic = array_merge($pagesPublic, $pagesInFooterAndMenu);
}
?>

<!-- Navigation -->
<nav class="navbar navbar-expand-xl navbar-light fixed-top" id="navBar">
    <div class="container">
        <div class="logo-container" id="logoContainer">
            <a class="navbar-brand logo" id="logo" href="/">
                <img src="/resources/assets/images/ccwesteinde_logo.svg" alt="CC Westeinde Logo">
            </a>
        </div>

        <div class="navBarToggler" id="navBarToggler">
            <button class="navbar-toggler button-unstyled" type="button" data-toggle="collapse"
                    data-target="#navbarResponsive" onclick="menuIsCollapsed()"
                    aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <img width="50px" src="/resources/assets/images/menu_toggle_icon_border_2.svg" alt="menu">
            </button>
        </div>

        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav nav-menu">
                <li class="nav-item">
                    <a class="nav-link text-white <?= URL::getUrl() === 'bedrijf' ? 'current' : '' ?>"
                       href="/bedrijf">
                        <span class="right-border">
                            <?= \App\model\translation\Translation::get('menu_item_bedrijf') ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= URL::getUrl() === 'student' ? 'current' : '' ?>"
                       href="/student">
                        <span class="right-border">
                            <?= \App\model\translation\Translation::get('menu_item_student') ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= URL::getUrl() === 'meet-the-expert' ? 'current' : '' ?>"
                       href="/meet-the-expert">
                        <span class="right-border">
                            <?= \App\model\translation\Translation::get('menu_item_meet_the_expert') ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= URL::getUrl() === 'projecten' ? 'current' : '' ?>"
                       href="/projecten">
                        <span class="right-border">
                            <?= \App\model\translation\Translation::get('menu_item_projecten') ?>
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link text-white" href="#" id="navbarDropdownSites"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?= \App\model\translation\Translation::get('menu_item_werkwijze') ?>
                        <svg style="fill: currentColor;" width="8" height="7" viewBox="-0.019531 -52.792969 30.039062 25.195312">
                            <path d="M29.941406 -52.500000C29.785156 -52.656250 29.589844 -52.753906 29.355469 -52.792969L0.644531 -52.792969C0.410156 -52.753906 0.214844 -52.656250 0.058594 -52.500000C-0.019531 -52.265625 0.000000 -52.050781 0.117188 -51.855469L14.472656 -27.890625C14.628906 -27.734375 14.804688 -27.636719 15.000000 -27.597656C15.234375 -27.636719 15.410156 -27.734375 15.527344 -27.890625L29.882812 -51.855469C30.000000 -52.089844 30.019531 -52.304688 29.941406 -52.500000ZM29.941406 -52.500000"></path>
                        </svg>
                    </a>
                    <div class="dropdown-menu green-bg" aria-labelledby="navbarDropdownSites">
                        <?php if (!empty($pagesPublic) && is_array($pagesPublic)) :
                            foreach ($pagesPublic as $singlePage) : ?>
                                <a class="dropdown-item text-white <?= ($singlePage['page_slug_name'] ?? '#') === URL::getUrl() ? 'current-light' : '' ?>"
                                   href="/<?= $singlePage['page_slug_name'] ?? '#' ?>">
                                    <?= htmlspecialchars_decode($singlePage['page_title'] ?? '') ?>
                                </a>
                            <?php endforeach;
                        endif; ?>
                    </div>
                </li>
                <?php if ($user->getRights() >= 1) : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#" id="navbarDropdownLoggedIn"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="left-border"></span>
                            Welkom <?= $user->account->account_name ?? '' ?>
                            <svg style="fill: currentColor;" width="8" height="7" viewBox="-0.019531 -52.792969 30.039062 25.195312">
                                <path d="M29.941406 -52.500000C29.785156 -52.656250 29.589844 -52.753906 29.355469 -52.792969L0.644531 -52.792969C0.410156 -52.753906 0.214844 -52.656250 0.058594 -52.500000C-0.019531 -52.265625 0.000000 -52.050781 0.117188 -51.855469L14.472656 -27.890625C14.628906 -27.734375 14.804688 -27.636719 15.000000 -27.597656C15.234375 -27.636719 15.410156 -27.734375 15.527344 -27.890625L29.882812 -51.855469C30.000000 -52.089844 30.019531 -52.304688 29.941406 -52.500000ZM29.941406 -52.500000"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu green-bg" aria-labelledby="navbarDropdownLoggedIn"
                             id="dropdownLoggedIn">
                            <?php if (!empty($pagesLoggedIn) && is_array($pagesLoggedIn)) :
                                foreach ($pagesLoggedIn as $singlePage) : ?>
                                    <a class="dropdown-item text-white <?= ($singlePage['page_slug_name'] ?? '#') === URL::getUrl() ? 'current-light' : '' ?>"
                                       href="/<?= $singlePage['page_slug_name'] ?? '#' ?>">
                                        <?= htmlspecialchars_decode($singlePage['page_title'] ?? '') ?>
                                    </a>
                                <?php endforeach;
                            endif;
                            if ($user->getRights() === 1) : ?>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'werkplek/reserveren' ? 'current-light' : '' ?>"
                                   href="/werkplek/reserveren">
                                    <?= \App\model\translation\Translation::get('menu_item_werkplek_reserveren') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'meet-the-experts' ? 'current-light' : '' ?>"
                                   href="/meet-the-experts">
                                    <?= \App\model\translation\Translation::get('menu_item_aanmelden_voor_meet_the_expert') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'aanmeldingen-en-reserveringen/beheren' ? 'current-light' : '' ?>"
                                   href="/aanmeldingen-en-reserveringen/beheren">
                                    <?= \App\model\translation\Translation::get('menu_item_aanmeldingen_en_reserveringen_beheren') ?>
                                </a>
                            <?php else: ?>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'werkplek/reserveren' ? 'current-light' : '' ?>"
                                   href="/werkplek/reserveren">
                                    <?= \App\model\translation\Translation::get('menu_item_werkplek_reserveren') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'events' ? 'current-light' : '' ?>"
                                   href="/events">
                                    <?= \App\model\translation\Translation::get('menu_item_meet_the_experts_beheren') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'aanmeldingen/beheren' ? 'current-light' : '' ?>"
                                   href="/aanmeldingen/beheren?limit=100">
                                    <?= \App\model\translation\Translation::get('menu_item_meet_the_expert_aanmeldingen_beheren') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'reserveringen/beheren' && $request->get('space') === 'werkplek' ? 'current-light' : '' ?>"
                                   href="/reserveringen/beheren?space=werkplek">
                                    <?= \App\model\translation\Translation::get('menu_item_werkplek_reserveringen_beheren') ?>
                                </a>
                                <a class="dropdown-item text-white <?= URL::getUrl() === 'reserveringen/beheren' && $request->get('space') === 'vergaderruimte' ? 'current-light' : '' ?>"
                                   href="/reserveringen/beheren?space=vergaderruimte">
                                    <?= \App\model\translation\Translation::get('menu_item_vergaderruimte_reserveringen_beheren') ?>
                                </a>
                            <?php endif; ?>
                            <a class="dropdown-item text-white <?= URL::getUrl() === 'account/bewerken' ? 'current-light' : '' ?>"
                               href="/account/bewerken">Account bewerken</a>
                            <a class="dropdown-item text-white <?= URL::getUrl() === 'uitloggen' ? 'current-light' : '' ?>"
                               href="/uitloggen">Uitloggen</a>
                        </div>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link text-white <?= URL::getUrl() === 'inloggen' ? 'current' : '' ?>"
                           href="/inloggen"><span class="left-border">Inloggen</span></a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
