<?php

/**
 * Rights:
 * 0 = Accessible for everyone
 * 1 = student
 * 2 = teacher
 * 3 = Admin
 * 4 = Super admin
 */

use App\services\core\Router;

/**
 * Pages.
 */
Router::get('', 'PageController@index');
Router::get('home', 'PageController@index');
Router::get('student', 'PageController@student');
Router::get('bedrijf', 'PageController@company');
Router::get('fourNullFour', 'PageController@pageNotFound');

/**
 * Portfolio page.
 */
Router::get('projecten', 'ProjectController@index');
Router::get('projecten/{slug}', 'ProjectController@show');

/**
 * Meet the expert page.
 */
Router::get('meet-the-expert', 'MeetTheExpertController@index');
Router::get('meet-the-experts', 'MeetTheExpertController@all');
Router::get('meet-the-experts/archief', 'MeetTheExpertController@allArchived');
Router::get('meet-the-expert/{slug}', 'MeetTheExpertController@show');
Router::get('meet-the-expert/{slug}/aanmelden', 'MeetTheExpertController@signUp', 1);
Router::post('meet-the-expert/{slug}/aanmelden', 'MeetTheExpertController@store', 1);
Router::get('meet-the-expert/{slug}/aanmelden-succesvol', 'MeetTheExpertController@sent', 1);


/**
 * Contact page.
 */
Router::get('contact', 'ContactController@index');
Router::post('contact', 'ContactController@contact');
Router::get('contact-verzonden', 'ContactController@sent');

/**
 * Account page.
 */
Router::get('inloggen', 'Controller@index');
Router::get('registreren', 'Controller@create');
Router::post('registreren', 'Controller@store');
Router::get('activeren', 'Controller@activate');
Router::post('inloggen', 'Controller@login');
Router::get('account/bewerken', 'Controller@edit', 1);
Router::post('account/updaten', 'Controller@update', 1);
Router::get('uitloggen', 'Controller@logout', 1);

/**
 * Reservation for workspace page.
 */
Router::get('werkplek/reserveren', 'ReservationController@index', 1);
Router::get('werkplek/reserveren/stap-2', 'ReservationController@step2', 1);
Router::get('werkplek/reserveren/stap-3', 'ReservationController@step3', 1);
Router::post('werkplek/reserveren', 'ReservationController@store', 1);
Router::get('werkplek/gereserveerd', 'ReservationController@sent', 1);

/**
 * Student sign ups and reservations maintenance
 */
Router::get('aanmeldingen-en-reserveringen/beheren', 'MaintenanceController@index',1);
Router::post('aanmeldingen-en-reserveringen/beheren/aanmelding/{slug}/verwijderen', 'MaintenanceController@destroySignUp', 1);
Router::post('aanmeldingen-en-reserveringen/beheren/reservering/{slug}/verwijderen', 'MaintenanceController@destroyReservation', 1);

/**
 * Teacher events maintenance.
 */
Router::get('events', 'EventController@index', 2);
Router::get('event/create', 'EventController@create', 2);
Router::post('event/store', 'EventController@store', 2);
Router::get('event/{slug}/edit', 'EventController@edit', 2);
Router::post('event/{slug}/archive', 'EventController@archive', 2);
Router::post('event/{slug}/recover', 'EventController@recover', 2);
Router::post('event/{slug}/update', 'EventController@update', 2);
Router::post('event/{slug}/delete', 'EventController@destroy', 2);

/**
 * Teacher sign ups maintenance page.
 */
Router::get('aanmeldingen/beheren', 'MaintenanceController@indexSignUpsTeacher',2);
Router::post('aanmeldingen/beheren/aanmelding/{slug}/verwijderen', 'MaintenanceController@destroySignUpAsTeacher', 1);

/**
 * Teacher reservations maintenance page.
 */
Router::get('reserveringen/beheren', 'MaintenanceController@indexReservationsTeacher',2);
Router::post('reserveringen/beheren/reservering/{slug}/verwijderen', 'MaintenanceController@destroyReservationAsTeacher', 1);
Router::get('event/{slug}/exporteren', 'MaintenanceController@export', 2);
Router::get('aanmeldingen/historie', 'MaintenanceController@indexSignUpsHistory',2);
Router::get('reserveringen/historie', 'MaintenanceController@indexReservationsHistory',2);

/**
 * Admin login.
 */
Router::get('admin', 'admin\Controller@index');
Router::post('admin/login', 'admin\Controller@login');

/**
 * Admin dashboard.
 */
Router::get('admin/dashboard', 'admin\DashboardController@index', 3);

/**
 * Admin pages.
 */
Router::get('admin/pages', 'admin\PageController@index', 3);
Router::get('admin/page/create', 'admin\PageController@create', 3);
Router::post('admin/page/store', 'admin\PageController@store', 3);
Router::get('admin/page/{slug}/edit', 'admin\PageController@edit', 3);
Router::post('admin/page/{slug}/update', 'admin\PageController@update', 3);
Router::post('admin/page/{slug}/delete', 'admin\PageController@destroy', 3);
Router::post('admin/upload', 'admin\PageController@upload', 2);

/**
 * Admin projects.
 */
Router::get('admin/projects', 'admin\ProjectController@index', 3);
Router::get('admin/project/create', 'admin\ProjectController@create', 3);
Router::post('admin/project/store', 'admin\ProjectController@store', 3);
Router::get('admin/project/{slug}/edit', 'admin\ProjectController@edit', 3);
Router::post('admin/project/{slug}/update', 'admin\ProjectController@update', 3);
Router::post('admin/project/{slug}/delete', 'admin\ProjectController@destroy', 3);

/**
 * Admin meet the experts events.
 */
Router::get('admin/events', 'admin\EventController@index', 3);
Router::get('admin/event/create', 'admin\EventController@create', 3);
Router::post('admin/event/store', 'admin\EventController@store', 3);
Router::get('admin/event/{slug}/edit', 'admin\EventController@edit', 3);
Router::post('admin/event/{slug}/archive', 'admin\EventController@archive', 3);
Router::post('admin/event/{slug}/recover', 'admin\EventController@recover', 3);
Router::post('admin/event/{slug}/update', 'admin\EventController@update', 3);
Router::post('admin/event/{slug}/delete', 'admin\EventController@destroy', 3);

/**
 * Admin contact -> branch
 */
Router::get('admin/branch', 'admin\BranchController@index', 3);
Router::post('admin/branch/store', 'admin\BranchController@store', 3);
Router::get('admin/branch/{slug}/edit', 'admin\BranchController@index', 3);
Router::post('admin/branch/{slug}/update', 'admin\BranchController@update', 3);
Router::post('admin/branch/{slug}/delete', 'admin\BranchController@destroy', 3);

/**
 * Admin contact -> landscape
 */
Router::get('admin/landscape', 'admin\LandscapeController@index', 3);
Router::post('admin/landscape/store', 'admin\LandscapeController@store', 3);
Router::get('admin/landscape/{slug}/edit', 'admin\LandscapeController@index', 3);
Router::post('admin/landscape/{slug}/update', 'admin\LandscapeController@update', 3);
Router::post('admin/landscape/{slug}/delete', 'admin\LandscapeController@destroy', 3);

/**
 * Admin contact -> persons
 */
Router::get('admin/contact', 'admin\ContactController@index', 3);
Router::get('admin/contact/create', 'admin\ContactController@index', 3);
Router::post('admin/contact/store', 'admin\ContactController@store', 3);
Router::get('admin/contact/{slug}/edit', 'admin\ContactController@index', 3);
Router::post('admin/contact/{slug}/update', 'admin\ContactController@update', 3);
Router::post('admin/contact/{slug}/delete', 'admin\ContactController@destroy', 3);

/**
 * Admin workspace
 */
Router::get('admin/workspace', 'admin\WorkspaceController@index', 3);
Router::post('admin/workspace/store', 'admin\WorkspaceController@store', 3);
Router::get('admin/workspace/{slug}/edit', 'admin\WorkspaceController@index', 3);
Router::post('admin/workspace/{slug}/update', 'admin\WorkspaceController@update', 3);
Router::post('admin/workspace/{slug}/delete', 'admin\WorkspaceController@destroy', 3);

/**
 * Admin settings.
 */
Router::get('admin/settings', 'admin\SettingsController@index', 3);
Router::post('admin/settings/store', 'admin\SettingsController@store', 3);

/**
 * Admin translations.
 */
Router::get('admin/translations', 'admin\TranslationController@index', 3);
Router::post('admin/translation/store', 'admin\TranslationController@store', 3);
Router::post('admin/translation/update', 'admin\TranslationController@update', 3);

/**
 * Admin user account.
 */
Router::get('admin/user/account', 'admin\AccountController@index', 3);
Router::post('admin/user/account/{slug}/update', 'admin\AccountController@update', 3);

/**
 * Admin maintenance account
 */
Router::get('admin/accounts', 'admin\AccountsController@index', 4);
Router::get('admin/account/create', 'admin\AccountsController@create', 4);
Router::post('admin/account/store', 'admin\AccountsController@store', 4);
Router::get('admin/account/{slug}/edit', 'admin\AccountsController@edit', 4);
Router::post('admin/account/{slug}/update', 'admin\AccountsController@update', 4);
Router::post('admin/account/{slug}/unblock', 'admin\AccountsController@unblock', 4);
Router::post('admin/account/{slug}/delete', 'admin\AccountsController@destroy', 4);

/**
 * Admin logout.
 */
Router::get('admin/account/logout', 'admin\Controller@logout', 3);

/**
 * Language.
 */
Router::get('language/dutch', 'admin\LanguageController@dutch');
