<?php


namespace App\contracts\models;

interface Model
{
    /**
     * Get a item by id.
     *
     * @return object
     */
    public function get();

    /**
     * Get all items.
     *
     * @return array
     */
    public function getAll();

    /**
     * Soft delete a item by id.
     *
     * @return bool
     */
    public function softDelete();
}
