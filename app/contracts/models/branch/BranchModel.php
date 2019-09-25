<?php


namespace App\contracts\models\branch;

interface BranchModel
{
    /**
     * Construct the branch
     */
    public function __construct();

    /**
     * Get a branch by id.
     *
     * @return object
     */
    public function get();

    /**
     * Get a branch by name.
     *
     * @return object
     */
    public function getByName();

    /**
     * Get a branch by id.
     *
     * @return array
     */
    public function getAll();

    /**
     * Soft delete a specific branch by id.
     *
     * @return bool
     */
    public function softDelete();
}
