<?php


namespace App\contracts\models;

interface EditModel
{
    /**
     * Execute the editing of the item.
     *
     * @return bool
     */
    public function execute();
}
