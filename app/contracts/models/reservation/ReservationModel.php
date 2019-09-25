<?php


namespace App\contracts\models\reservation;


use Cake\Chronos\Chronos;

interface ReservationModel
{
    /**
     * Construct the reservation
     */
    public function __construct();

    /**
     * Calculate the occupancy rating of the workspaces at a specific day.
     *
     * @param Chronos $date                The date to ge the reservations for.
     * @param int     $maximumReservations The maximum of reservation per worksspace.
     *
     * @return float|int
     */
    public function calculateWorkspaceOccupancyRating(Chronos $date, int $maximumReservations = 1);

    /**
     * Calculate the occupancy rating of the meeting rooms at a specific day.
     *
     * @param Chronos $date The date to get the reservations for.
     *
     * @return float|int
     */
    public function calculateMeetingRoomOccupancyRating(Chronos $date);

    /**
     * Calculate the occupancy rating of a workspace
     *
     * @param array $reservations All the reservation by the workspace
     *
     * @return float|int
     */
    public function calculateOccupancyRatingByWorkspace(array $reservations);

    /**
     * Get the reservation.
     *
     * @return object
     */
    public function get();

    /**
     * Get the reservation by workspace and datetime.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function getByWorkspaceAndDateTime(int $workspaceID = 0);

    /**
     * Get the reservation by workspace and between the start or end datetime.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function getByWorkspaceInBetweenStartOrEndDateTime(int $workspaceID = 0);

    /**
     * Check if the current reservation date is between a other reservation start en end date.
     *
     * @param int $workspaceID The id of the workspace.
     *
     * @return object
     */
    public function checkIfThereIsAOtherReservationBetweenTheCurrentDate(int $workspaceID = 0);

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAll();

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAllByUserAndWorkspace();

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $workspaceID The id of the workspace.
     * @param string $startDate   The start date.
     * @param string $endDate     The end date.
     *
     * @return array
     */
    public function getAllByWorkspaceByDate(int $workspaceID, string $startDate, string $endDate);

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $slugID    The slug id.
     * @param string $startDate The start date.
     * @param string $endDate   The end date.
     *
     * @return object
     */
    public function getAllByDate(int $slugID, string $startDate, string $endDate);

    /**
     * Get all the reservations by a workspace
     *
     * @param int    $slugID    The slug id.
     * @param string $startDate The start date.
     * @param string $endDate   The end date.
     *
     * @return array
     */
    public function getAllMeetingRoomReservationsByDate(int $slugID, string $startDate, string $endDate);

    /**
     * Get all the reservations.
     *
     * @return array
     */
    public function getAllByUserAndMeetingRoom();

    /**
     * Soft delete an event by id as a student.
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

    /**
     * Get the kind of the reservation
     *
     * @param bool $converted Determine if the kind must be parsed
     *
     * @return string|int
     */
    public function getKind(bool $converted = true);

    /**
     * Get the day part of the reservation
     *
     * @param bool $converted Determine if the day part must be parsed
     *
     * @return string
     */
    public function getDayPart(bool $converted = true);

    /**
     * Get the date of the reservation
     *
     * @param bool $converted Determine if the date must be parsed
     *
     * @return string
     */
    public function getDate(bool $converted = true);

    /**
     * Get the time.
     *
     * @return string
     */
    public function getTime();

    /**
     * Get the duration of the reservation
     *
     * @param bool $converted Determine if the duration must be parsed
     *
     * @return string|int
     */
    public function getDuration(bool $converted = true);
}