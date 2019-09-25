<?php


namespace App\contracts\models\page;

interface FileModelInterface
{
    /**
     * Construct the file.
     */
    public function __construct();

    /**
     * Upload a new file.
     *
     * @return bool|string
     */
    public function upload();
}
