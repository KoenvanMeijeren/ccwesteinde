<?php

use App\model\admin\account\User;
use App\services\core\Translation;
use App\services\core\URL;

$user = new User();
?>

<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a class="logo" href="/admin/dashboard">
                    <img src="/resources/assets/images/ccwesteinde_logo.svg" alt="CC Westeinde Logo"/>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <?php if ($user->getRights() >= 3) : ?>
                    <li>
                        <a href="/admin/dashboard" class="<?= URL::getUrl() === 'admin/dashboard' ? 'current' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <?= Translation::get('admin_menu_dashboard') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pages" class="<?= URL::getUrl() === 'admin/pages' ? 'current' : '' ?>">
                            <i class="fas fa-pager"></i>
                            <?= Translation::get('admin_menu_pages') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/projects" class="<?= URL::getUrl() === 'admin/projects' ? 'current' : '' ?>">
                            <i class="fas fa-history"></i>
                            <?= Translation::get('admin_menu_projects') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/branch"
                           class="<?= URL::getUrl() === 'admin/branch' ? 'current' : '' ?>">
                            <i class="fas fa-directions"></i><?= Translation::get('admin_menu_branch') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/landscape' ? 'current' : '' ?>"
                           href="/admin/landscape">
                            <i class="fas fa-user-graduate"></i><?= Translation::get('admin_menu_landscape') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/contact' ? 'current' : '' ?>"
                           href="/admin/contact">
                            <i class="far fa-address-book"></i><?= Translation::get('admin_menu_contact') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/workspace" class="<?= URL::getUrl() === 'admin/workspace' ? 'current' : '' ?>">
                            <i class="fas fa-project-diagram"></i><?= Translation::get('admin_menu_workspace') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/events" class="<?= URL::getUrl() === 'admin/events' ? 'current' : '' ?>">
                            <i class="far fa-calendar-plus"></i><?= Translation::get('admin_menu_events') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/translations" class="<?= URL::getUrl() === 'admin/translations' ? 'current' : '' ?>">
                            <i class="fas fa-language"></i>
                            <?= Translation::get('admin_menu_translations') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/settings" class="<?= URL::getUrl() === 'admin/settings' ? 'current' : '' ?>">
                            <i class="fas fa-cog"></i>
                            <?= Translation::get('admin_menu_settings') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/user/account' ? 'current' : '' ?>"
                           href="/admin/user/account">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?= Translation::get('admin_menu_account_maintenance') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/admin/account/logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <?= Translation::get('admin_menu_logout') ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="/admin/dashboard">
            <img src="/resources/assets/images/ccwesteinde_logo.svg" alt="CC Westeinde Logo"/>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <?php if ($user->getRights() >= 3) : ?>
                    <li>
                        <a href="/admin/dashboard" class="<?= URL::getUrl() === 'admin/dashboard' ? 'current' : '' ?>">
                            <i class="fas fa-tachometer-alt"></i>
                            <?= Translation::get('admin_menu_dashboard') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/pages" class="<?= URL::getUrl() === 'admin/pages' ? 'current' : '' ?>">
                            <i class="fas fa-pager"></i>
                            <?= Translation::get('admin_menu_pages') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/projects" class="<?= URL::getUrl() === 'admin/projects' ? 'current' : '' ?>">
                            <i class="fas fa-history"></i>
                            <?= Translation::get('admin_menu_projects') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/branch"
                           class="<?= URL::getUrl() === 'admin/branch' ? 'current' : '' ?>">
                            <i class="fas fa-directions"></i><?= Translation::get('admin_menu_branch') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/landscape' ? 'current' : '' ?>"
                           href="/admin/landscape">
                            <i class="fas fa-user-graduate"></i><?= Translation::get('admin_menu_landscape') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/contact' ? 'current' : '' ?>"
                           href="/admin/contact">
                            <i class="far fa-address-book"></i><?= Translation::get('admin_menu_contact') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/workspace" class="<?= URL::getUrl() === 'admin/workspace' ? 'current' : '' ?>">
                            <i class="fas fa-project-diagram"></i><?= Translation::get('admin_menu_workspace') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/events" class="<?= URL::getUrl() === 'admin/events' ? 'current' : '' ?>">
                            <i class="far fa-calendar-plus"></i><?= Translation::get('admin_menu_events') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/translations" class="<?= URL::getUrl() === 'admin/translations' ? 'current' : '' ?>">
                            <i class="fas fa-language"></i>
                            <?= Translation::get('admin_menu_translations') ?>
                        </a>
                    </li>
                    <li>
                        <a href="/admin/settings" class="<?= URL::getUrl() === 'admin/settings' ? 'current' : '' ?>">
                            <i class="fas fa-cog"></i>
                            <?= Translation::get('admin_menu_settings') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item <?= URL::getUrl() === 'admin/user/account' ? 'current' : '' ?>"
                           href="/admin/user/account">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <?= Translation::get('admin_menu_account_maintenance') ?>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/admin/account/logout">
                            <i class="fas fa-sign-out-alt"></i>
                            <?= Translation::get('admin_menu_logout') ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->