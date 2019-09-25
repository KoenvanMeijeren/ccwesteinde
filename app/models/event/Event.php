<?php


namespace App\model\event;

use App\contracts\models\event\EventModel;
use App\services\core\Router;
use App\services\database\DB;

class Event implements EventModel
{
    /**
     * The id of the event.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * Construct the event
     */
    public function __construct()
    {
        $this->id = intval(Router::getWildcard());
    }

    /**
     * Get all events by sign ups.
     *
     * @return object
     */
    public function get()
    {
        $event = DB::table('event', 3)
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_ID', '=', $this->id)
            ->where('event_is_archived', '=', 0)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
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
        $event = DB::table('event', 3)
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_ID', '=', $this->id)
            ->where('event_is_archived', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_is_archived', '=', 0)
            ->where('event_is_deleted', '=', 0)
            ->where('event_start_datetime', '>=', date('Y-m-d H:i:s'))
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
            ->orderBy('ASC', 'event_start_datetime')
            ->execute()
            ->all();

        return $events;
    }

    /**
     * Get all events.
     *
     * @param int $number Limit the number of events to be returned.
     *
     * @return array
     */
    public function getAllLimited(int $number = 4)
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_start_datetime', '>=', date('Y-m-d H:i:s'))
            ->where('event_is_archived', '=', 0)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
            ->orderBy('ASC', 'event_start_datetime')
            ->limit($number)
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_is_archived', '=', 1)
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
     * @param int $number Limit the number of archived events to be returned.
     *
     * @return array
     */
    public function getAllArchivedLimited(int $number = 4)
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
                'COUNT(signUp_ID) AS event_sign_ups'
            )
            ->innerJoin('file AS fileA', 'fileA.file_ID', 'event_thumbnail_ID')
            ->innerJoin('file AS fileB', 'fileB.file_ID', 'event_banner_ID')
            ->leftJoin('signup', 'event.event_ID', 'signup.signUp_event_ID')
            ->where('event_is_archived', '=', 1)
            ->where('event_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->groupBy('event_ID')
            ->orderBy('ASC', 'event_start_datetime')
            ->limit($number)
            ->execute()
            ->all();

        return $events;
    }
}
