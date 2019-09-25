<?php


namespace App\controllers;

use App\model\admin\events\Event;
use App\model\admin\events\MakeEvent;
use App\model\admin\events\UpdateEvent;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;

class EventController
{
    /**
     * The events
     *
     * @var Event
     */
    private $event;

    /**
     * Construct the event controller
     */
    public function __construct()
    {
        $this->event = new Event();
    }

    /**
     * Overview of all events and archived events.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('admin_events_maintenance_title');
        $events = $this->event->getAll();
        $archivedEvents = $this->event->getAllArchived();

        return new View('events/index', compact('title', 'events', 'archivedEvents'));
    }

    /**
     * Show the form to create a new event.
     *
     * @return View
     */
    public function create()
    {
        $title = Translation::get('admin_create_event_title');

        return new View('events/edit', compact('title'));
    }

    /**
     * Proceed the user call from the method create and store it.
     *
     * @return RedirectResponse|View
     */
    public function store()
    {
        $makeEvent = new MakeEvent();
        if ($makeEvent->execute()) {
            return new RedirectResponse('/events');
        }

        return $this->create();
    }

    /**
     * Show the form to edit an event.
     *
     * @return View
     */
    public function edit()
    {
        $title = Translation::get('admin_edit_event_title');
        $event = $this->event->get();
        if (empty($event)) {
            $event = $this->event->getArchived();
        }

        return new View('events/edit', compact('title', 'event'));
    }

    /**
     * Update an event.
     *
     * @return RedirectResponse|View
     */
    public function update()
    {
        $updateEvent = new UpdateEvent();
        if ($updateEvent->execute()) {
            return new RedirectResponse('/events');
        }

        return $this->edit();
    }

    /**
     * Archive an event
     *
     * @return RedirectResponse
     */
    public function archive()
    {
        $this->event->archive();

        return new RedirectResponse('/events');
    }

    /**
     * Recover an archived event
     *
     * @return RedirectResponse
     */
    public function recover()
    {
        $this->event->archive(0);

        return new RedirectResponse('/events');
    }

    /**
     * Soft delete an event
     *
     * @return RedirectResponse
     */
    public function destroy()
    {
        $this->event->softDelete();

        return new RedirectResponse('/events');
    }
}
