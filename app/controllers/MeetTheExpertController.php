<?php


namespace App\controllers;

use App\contracts\controllers\OverviewAndSpecificControllerInterface;
use App\model\admin\account\User;
use App\model\admin\page\Page;
use App\model\signUp\MakeSignUp;
use App\model\event\Event;
use App\model\signUp\SignUp;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\core\URL;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;

class MeetTheExpertController implements OverviewAndSpecificControllerInterface
{
    /**
     * The event
     *
     * @var Event
     */
    private $event;

    /**
     * The sign up
     *
     * @var SignUp
     */
    private $userSignUp;

    /**
     * Construct the event controller
     */
    public function __construct()
    {
        $this->event = new Event();
        $this->userSignUp = new SignUp();
    }

    /**
     * Show the events page.
     *
     * @return View
     */
    public function index()
    {
        $page = new Page('meet-the-expert');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('meet_the_expert_page_title');
        $events = $this->event->getAllLimited();
        $archivedEvents = $this->event->getAllArchivedLimited();

        return new View('event/index', compact('title', 'page', 'events', 'archivedEvents'));
    }

    /**
     * Show the events page.
     *
     * @return View|RedirectResponse
     */
    public function all()
    {
        $page = new Page('meet-the-expert');
        $user = new User();

        if (URL::getPreviousUrl() === 'student' && $user->getRights() < 1) {
            Session::save('path', URL::getUrl());
            return new RedirectResponse('/inloggen');
        }

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('meet_the_expert_page_title');
        $events = $this->event->getAll();

        return new View('event/all', compact('title', 'events', 'page'));
    }

    /**
     * Show the events page.
     *
     * @return View
     */
    public function allArchived()
    {
        $page = new Page('meet-the-expert-gearchiveerd');

        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('meet_the_expert_page_title');
        $events = $this->event->getAllArchived();

        return new View('event/all', compact('title', 'events', 'page'));
    }

    /**
     * Show one event.
     *
     * @return View|RedirectResponse
     */
    public function show()
    {
        if (empty($this->event->get()) && empty($this->event->getArchived())) {
            Session::flash('error', Translation::get('event_cannot_be_visited'));
            return new RedirectResponse('/meet-the-expert');
        }

        $event = $this->event->get();
        if (empty($event)) {
            $event = $this->event->getArchived();
        }
        $title = $event->event_title ?? '';
        $signUpsNumber = count($this->userSignUp->getAllEventByUser());

        return new View('event/event', compact('title', 'event', 'signUpsNumber'));
    }

    /**
     * Show the sign up for event page.
     *
     * @return View
     */
    public function signUp()
    {
        $title = Translation::get('event_page_title');
        $event = $this->event->get();
        $signUpsNumber = count($this->userSignUp->getAllEventByUser());

        return new View('event/signUp', compact('title', 'event', 'signUpsNumber'));
    }

    /**
     * Proceed the user call from the sign up page and process it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeSignUp = new MakeSignUp();
        if (CSRF::validate() && $makeSignUp->execute()) {
            return new RedirectResponse('/meet-the-expert/'.Router::getWildcard().'/aanmelden-succesvol');
        }

        return $this->signUp();
    }

    /**
     * Show the sign up for event page.
     *
     * @return View
     */
    public function sent()
    {
        $title = Translation::get('event_page_title');
        $event = $this->event->get();
        $signUpsNumber = count($this->userSignUp->getAllEventByUser());

        return new View('event/signUp', compact('title', 'event', 'signUpsNumber'));
    }
}
