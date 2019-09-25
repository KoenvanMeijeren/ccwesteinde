<?php


namespace App\controllers;

use App\model\admin\page\Page;
use App\model\admin\settings\Settings;
use App\model\admin\workspace\Workspace;
use App\model\reservation\MakeReservation;
use App\model\reservation\Reservation;
use App\services\core\Request;
use App\services\core\Translation;
use App\services\core\View;
use App\services\response\RedirectResponse;
use App\services\security\CSRF;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class ReservationController
{
    /**
     * The reservation object
     *
     * @var Reservation
     */
    private $reservation;

    /**
     * The workspace object
     *
     * @var Workspace
     */
    private $workspace;

    /**
     * The page object
     *
     * @var Page
     */
    private $page;

    /**
     * The workspace picture path
     *
     * @var string
     */
    private $path;

    /**
     * Construct the workspaces
     */
    public function __construct()
    {
        $this->workspace = new Workspace();
        $this->page = new Page('werkplek-reserveren');
        $this->reservation = new Reservation();
        $settings = new Settings();
        $this->path = $settings->get('workspace_image');
    }

    /**
     * Show the reservation page.
     *
     * @return View
     */
    public function index()
    {
        $title = $this->page->getBySlug()->page_title ?? Translation::get('reservation_page_title');
        $path = $this->path;
        $workspaces = $this->workspace->getUniqueRows();
        $page = $this->page->getBySlug();

        return new View('reservation/index', compact('title', 'page', 'path', 'workspaces'));
    }

    /**
     * Show the next step in the reservation process.
     *
     * @return View|RedirectResponse
     */
    public function step2()
    {
        $title = $this->page->getBySlug()->page_title ?? Translation::get('reservation_page_title');
        $path = $this->path;
        $kind = $this->reservation->getKind();

        if (empty($kind)) {
            return new RedirectResponse('/werkplek/reserveren');
        }

        return new View('reservation/step2', compact('title', 'path', 'kind'));
    }

    /**
     * Show the next step in the reservation process.
     *
     * @return View|RedirectResponse
     */
    public function step3()
    {
        $path = $this->path;
        $kind = $this->reservation->getKind();
        $date = $this->reservation->getDate();
        $time = $this->reservation->getTime();
        $dayPart = $this->reservation->getDayPart();
        $duration = $this->reservation->getDuration();
        $workspaces = $this->workspace->getAllBySlug();

        if ($kind === 'werkplek') {
            $title = ucfirst($kind) . ' reserveren in de ' . $dayPart . ' op ' . $date;
        } elseif ($kind === 'vergaderruimte') {
            $title = ucfirst($kind) . ' reserveren ' . $duration . ' op ' . $date;
        }

        $reservationDate = new Chronos($this->reservation->getDate(false));
        if ($reservationDate->isWeekend()) {
            Session::flash('error', Translation::get('cannot_reserve_workspace_in_weekend'));
            return new RedirectResponse("/werkplek/reserveren/stap-2?kind={$kind}&date={$date}&time={$time}&dayPart={$dayPart}&duration={$duration}");
        }

        if (!$reservationDate->isToday() && !$reservationDate->isFuture()) {
            Session::flash('error', Translation::get('workspace_cannot_reserved_earlier_than_now'));
            return new RedirectResponse("/werkplek/reserveren/stap-2?kind={$kind}&date={$date}&time={$time}&dayPart={$dayPart}&duration={$duration}");
        }

        if ($kind === 'vergaderruimte' && empty($time)) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return new RedirectResponse('/werkplek/reserveren');
        }

        if (empty($kind) || (empty($dayPart) && empty($duration))) {
            Session::flash('error', Translation::get('form_invalid_data'));
            return new RedirectResponse('/werkplek/reserveren');
        }

        return new View('reservation/step3', compact('title', 'path', 'pageTitle', 'kind', 'workspaces'));
    }

    /**
     * Proceed the user call from the reservation process and reserve a workspace.
     *
     * @return View|RedirectResponse
     */
    public function store()
    {
        $reserve = new MakeReservation();
        $request = new Request();

        if (CSRF::validate() && $reserve->execute()) {
            return new RedirectResponse('/werkplek/gereserveerd');
        }

        $kind = $request->post('kind');
        $date = $request->post('date');
        $time = $request->post('time');
        $dayPart = $request->post('dayPart');
        $duration = $request->post('duration');

        return new RedirectResponse("/werkplek/reserveren/stap-3?kind={$kind}&date={$date}&time={$time}&dayPart={$dayPart}&duration={$duration}");
    }

    /**
     * Show the reservation sent page.
     *
     * @return View
     */
    public function sent()
    {
        $page = new Page('werkplek-reservering-verzonden');
        $page = $page->getBySlug();
        $title = $page->page_title ?? Translation::get('reservation_page_title');

        return new View('reservation/sent', compact('title', 'page'));
    }
}
