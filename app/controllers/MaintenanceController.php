<?php

namespace App\controllers;

use App\model\admin\page\Slug;
use App\model\admin\settings\Settings;
use App\model\admin\workspace\Workspace;
use App\model\event\Event;
use App\model\reservation\Reservation;
use App\model\signUp\SignUp;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use Cake\Chronos\Chronos;

class MaintenanceController
{
    /**
     * The sign ups.
     *
     * @var SignUp
     */
    private $signUp;

    /**
     * The reservations.
     *
     * @var Reservation
     */
    private $reservation;

    /**
     * Construct the sign up.
     */
    public function __construct()
    {
        $this->signUp = new SignUp();
        $this->reservation = new Reservation();
    }

    /**
     * Show the maintenance page for the student.
     *
     * @return View
     */
    public function index()
    {
        $title = Translation::get('maintenance_page_title');
        $signUps = $this->signUp->getAllByUser();
        $workspaceReservations = $this->reservation->getAllByUserAndWorkspace();
        $meetingRoomReservations = $this->reservation->getAllByUserAndMeetingRoom();

        return new View(
            'maintenance/student',
            compact('title', 'signUps', 'workspaceReservations', 'meetingRoomReservations')
        );
    }

    /**
     * Show the sign ups maintenance page for the teacher.
     *
     * @return View
     */
    public function indexSignUpsTeacher()
    {
        $request = new Request();

        $title = Translation::get('sign_ups_maintenance_page_title');
        $signUps = $this->signUp->getAllEvents((int) ($request->get('limit')));

        return new View('maintenance/sign_ups', compact('title', 'signUps'));
    }

    /**
     * Show the reservations maintenance page for the teacher.
     *
     * @return View
     */
    public function indexReservationsTeacher()
    {
        $workspace = new Workspace();
        $settings = new Settings();
        $request = new Request();
        $slug = new Slug(0, $request->get('space'));
        $workspace->setSlugID($slug->id);

        $title = Translation::get('reservations_maintenance_page_title');
        $workspaces = $workspace->getAllBySlug();

        if ('werkplek' === $request->get('space')) {
            $quantityOptions = 2;
            $maximumReservations = (int) (\count($workspaces)) * 2;
        } elseif ('vergaderruimte' === $request->get('space')) {
            $openingHour = new Chronos($settings->get('schoolOpeningHour'));
            $closingHour = new Chronos($settings->get('schoolClosingHour'));

            $quantityOptions = $closingHour->diffInMinutes($openingHour);
        }

        return new View(
            'maintenance/reservations',
            compact('title', 'workspaces', 'maximumReservations', 'quantityOptions')
        );
    }

    /**
     * Show the history of sign ups for events.
     *
     * @return View
     */
    public function indexSignUpsHistory()
    {
        $request = new Request();

        $title = Translation::get('sign_ups_maintenance_page_title');
        $signUps = $this->signUp->getAllEventsHistory((int) ($request->get('limit')));

        return new View('maintenance/history_sign_ups', compact('title', 'signUps'));
    }

    /**
     * Show the history of sign ups for events.
     *
     * @return View
     */
    public function indexReservationsHistory()
    {
        $workspace = new Workspace();
        $request = new Request();
        $settings = new Settings();
        $slug = new Slug(0, $request->get('space'));
        $workspace->setSlugID($slug->id);

        $title = Translation::get('reservations_maintenance_page_title');
        $workspaces = $workspace->getAllBySlug();

        if ('werkplek' === $request->get('space')) {
            $quantityOptions = 2;
            $maximumReservations = (int) (\count($workspaces)) * 2;
        } elseif ('vergaderruimte' === $request->get('space')) {
            $openingHour = new Chronos($settings->get('schoolOpeningHour'));
            $closingHour = new Chronos($settings->get('schoolClosingHour'));

            $quantityOptions = $closingHour->diffInMinutes($openingHour) * count($workspaces);
        }

        return new View(
            'maintenance/history_reservations',
            compact('title', 'workspaces', 'maximumReservations', 'quantityOptions')
        );
    }

    /**
     * Proceed the user call and export a csv of the sign ups at a specific event.
     */
    public function export()
    {
        $event = new Event();

        $event = $event->get();
        $signUps = $this->signUp->getAllPerEvent((int) (Router::getWildcard()));

        $header = [
            'Titel',
            'Datum en tijdstip',
            'Locatie',
            'Aantal personen',
        ];
        $mainData = [
            $event->event_title ?? '',
            parseToDate($event->event_start_datetime ?? '')
            .' van '.parseToTime($event->event_start_datetime ?? '')
            .' - '.parseToTime($event->event_end_datetime ?? ''),
            $event->event_location ?? '',
            $event->event_maximum_persons ?? '',
        ];

        $array = [
            $header,
            $mainData,
            ['Deelnemers'],
            ['Naam', 'Email', 'Opleiding'],
        ];

        if (!empty($signUps) && \is_array($signUps)) {
            foreach ($signUps as $signUp) {
                $array[] = [
                    $signUp->signUp_user_name ?? '',
                    $signUp->signUp_user_email ?? '',
                    $signUp->signUp_user_education ?? '',
                ];
            }
        }

        outputCsv('deelnemerslijst_'.$event->event_title ?? '', $array);
    }

    /**
     * Destroy a sign up for an event.
     *
     * @return RedirectResponse
     */
    public function destroySignUp()
    {
        $this->signUp->softDeleteAsUser();

        return new RedirectResponse('/aanmeldingen-en-reserveringen/beheren');
    }

    /**
     * Destroy a sign up for an event as teacher.
     *
     * @return RedirectResponse
     */
    public function destroySignUpAsTeacher()
    {
        $this->signUp->softDelete();

        return new RedirectResponse('/aanmeldingen/beheren?limit=100');
    }

    /**
     * Destroy a reservation.
     *
     * @return RedirectResponse
     */
    public function destroyReservation()
    {
        $this->reservation->softDeleteAsUser();

        return new RedirectResponse('/aanmeldingen-en-reserveringen/beheren');
    }

    /**
     * Destroy a reservation as teacher.
     *
     * @return RedirectResponse
     */
    public function destroyReservationAsTeacher()
    {
        $request = new Request();
        $this->reservation->softDelete();

        return new RedirectResponse('/reserveringen/beheren?space='.$request->post('space'));
    }
}
