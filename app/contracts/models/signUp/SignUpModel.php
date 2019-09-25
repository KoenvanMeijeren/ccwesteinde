<?php


namespace App\contracts\models\signUp;


interface SignUpModel
{
    /**
     * Construct the sign up.
     */
    public function __construct();

    /**
     * Get a sign up.
     *
     * @return object
     */
    public function get();

    /**
     * Get all sign ups by user.
     *
     * @return array
     */
    public function getAllByUser();

    /**
     * Get all sign ups per event.
     *
     * @param int $limit The maximum number of records to be returned.
     *
     * @return array
     */
    public function getAllEvents(int $limit);

    /**
     * Get all sign ups per event.
     *
     * @param int $limit The maximum number of records to be returned.
     *
     * @return array
     */
    public function getAllEventsHistory(int $limit);

    /**
     * Get all sign ups per event.
     *
     * @param int $eventID The id of the event to get the sign ups for.
     *
     * @return array
     */
    public function getAllPerEvent(int $eventID);

    /**
     * Get all sign ups by user.
     *
     * @return array
     */
    public function getAllEventByUser();

    /**
     * Soft delete an event by id as student.
     *
     * @return bool
     */
    public function softDeleteAsUser();

    /**
     * Soft delete an event by id.
     *
     * @return bool
     */
    public function softDelete();


}