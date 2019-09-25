<?php


namespace App\model\admin\events;

use App\contracts\models\Model;
use App\model\admin\page\GetFile;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class Event implements Model
{
    /**
     * The id of the event.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The thumbnail id of the event.
     *
     * @var int
     */
    protected $thumbnailID = 0;

    /**
     * The banner id of the event
     *
     * @var int
     */
    protected $bannerID = 0;

    /**
     * The title of the event
     *
     * @var string
     */
    protected $title = '';

    /**
     * The content of the event
     *
     * @var string
     */
    protected $content = '';

    /**
     * The start datetime of the event
     *
     * @var string
     */
    protected $startDatetime;

    /**
     * The end datetime of the event
     *
     * @var string
     */
    protected $endDatetime;

    /**
     * The location of the event
     *
     * @var string
     */
    protected $location = '';

    /**
     * The maximum number of sign ups for the event.
     *
     * @var int
     */
    protected $maximumSignUps = 0;

    /**
     * Construct the event
     */
    public function __construct()
    {
        $request = new Request();

        $this->id = intval(Router::getWildcard());
        $this->title = ucfirst($request->post('title'));
        $this->content = $request->post('content');

        $date = $request->post('date');
        $startTime = $request->post('startTime');
        $endTime = $request->post('endTime');
        $startDate = new Chronos($date . $startTime);
        $endDate = new Chronos($date . $endTime);
        $this->startDatetime = $startDate->toDateTimeString();
        $this->endDatetime = $endDate->toDateTimeString();

        $this->location = ucfirst($request->post('location'));
        $this->maximumSignUps = intval($request->post('maximumSignUps'));

        $thumbnail = new GetFile($request->post('thumbnail'));
        $this->thumbnailID = $thumbnail->getID();

        $header = new GetFile($request->post('header'));
        $this->bannerID = $header->getID();
    }

    /**
     * Get an event by id.
     *
     * @return object
     */
    public function get()
    {
        $event = DB::table('event', 2)
            ->select(
                'event_ID',
                'event_thumbnail_ID',
                'fileA.file_path AS thumbnail_path',
                'event_banner_ID',
                'fileB.file_path AS banner_path',
                'event_title',
                'event_content',
                'event_start_datetime',
                'event_end_datetime',
                'event_location',
                'event_maximum_persons',
                'event_is_archived'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->where('event_ID', '=', $this->id)
            ->where('event_is_archived', '=', 0)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $event;
    }

    /**
     * Get an archived event by id.
     *
     * @return object
     */
    public function getArchived()
    {
        $event = DB::table('event', 2)
            ->select(
                'event_ID',
                'event_thumbnail_ID',
                'fileA.file_path AS thumbnail_path',
                'event_banner_ID',
                'fileB.file_path AS banner_path',
                'event_title',
                'event_content',
                'event_start_datetime',
                'event_end_datetime',
                'event_location',
                'event_maximum_persons',
                'event_is_archived'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->where('event_ID', '=', $this->id)
            ->where('event_is_archived', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $event;
    }

    /**
     * Get all events.
     *
     * @return array
     */
    public function getAll()
    {
        $events = DB::table('event', 3)
            ->select(
                'event_ID',
                'event_thumbnail_ID',
                'fileA.file_path AS thumbnail_path',
                'event_banner_ID',
                'fileB.file_path AS banner_path',
                'event_title',
                'event_content',
                'event_start_datetime',
                'event_end_datetime',
                'event_location',
                'event_maximum_persons',
                'event_is_archived',
                'COUNT(signUp_ID) AS quantitySignUps'
            )
            ->leftJoin('signup', 'signUp_event_ID', 'event_ID')
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->where('event_is_archived', '=', 0)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
            ->orderBy('ASC', 'event_start_datetime')
            ->execute()
            ->all();

        return $events;
    }

    /**
     * Get all archived events.
     *
     * @return array
     */
    public function getAllArchived()
    {
        $events = DB::table('event', 2)
            ->select(
                'event_ID',
                'event_thumbnail_ID',
                'fileA.file_path AS thumbnail_path',
                'event_banner_ID',
                'fileB.file_path AS banner_path',
                'event_title',
                'event_content',
                'event_start_datetime',
                'event_end_datetime',
                'event_location',
                'event_maximum_persons',
                'event_is_archived'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->where('event_is_archived', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->orderBy('DESC', 'event_ID')
            ->execute()
            ->all();

        return $events;
    }

    /**
     * Archive an event by id.
     *
     * @param int $value The state of archived
     *
     * @return bool
     */
    public function archive(int $value = 1)
    {
        $event = $this->get();
        $eventDate = new Chronos($event->event_start_datetime ?? '');
        $date = new Chronos();

        if ($eventDate->toDateTimeString() > $date->toDateTimeString()) {
            Session::flash('error', Translation::get('cannot_archive_event_if_it_has_not_been_held_yet'));
            return false;
        }

        $archived = DB::table('event')
            ->update(['event_is_archived' => $value])
            ->where('event_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($archived && $value === 1) {
            Session::flash('success', Translation::get('event_successful_archived'));
            return true;
        }

        if ($archived && $value === 0) {
            Session::flash('success', Translation::get('event_successful_recovered'));
            return true;
        }

        Session::flash('error', Translation::get('event_unsuccessful_archived'));
        return false;
    }

    /**
     * Soft delete an event by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        if ($this->signUpsForEvent()) {
            Session::flash('error', Translation::get('cannot_delete_event_if_there_are_sign_ups'));
            return false;
        }

        $softDeleted = DB::table('event')
            ->softDelete('event_is_deleted')
            ->where('event_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('event_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('event_unsuccessful_deleted'));
        return false;
    }

    /**
     * Check if there are sign ups for this event
     *
     * @return bool
     */
    protected function signUpsForEvent()
    {
        $date = new Chronos();
        $signUpsForThisEvent = DB::table('event', 1)
            ->select('event_ID')
            ->innerJoin('signup', 'event_ID', 'signUp_event_ID')
            ->where('signUp_is_deleted', '=', 0)
            ->where('event_ID', '=', $this->id)
            ->where('event_start_datetime', '>=', $date->toDateTimeString())
            ->where('event_is_deleted', '=', 0)
            ->execute()
            ->first();

        if (!empty($signUpsForThisEvent)) {
            return true;
        }

        return false;
    }
}
