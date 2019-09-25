<?php


namespace App\contracts\models\event;


interface EventModel
{
    /**
     * Construct the event
     */
    public function __construct();

    /**
     * Get all events by sign ups.
     *
     * @return object
     */
    public function get();

    /**
     * Get an archived event by id.
     *
     * @return object
     */
    public function getArchived();

    /**
     * Get all events.
     *
     * @return array
     */
    public function getAll();

    /**
     * Get all events.
     *
     * @param int $number Limit the number of events to be returned.
     *
     * @return array
     */
    public function getAllLimited(int $number = 4);

    /**
     * Get all archived events.
     *
     * @return array
     */
    public function getAllArchived();

    /**
     * Get all archived events.
     *
     * @param int $number Limit the number of archived events to be returned.
     *
     * @return array
     */
    public function getAllArchivedLimited(int $number = 4);


}