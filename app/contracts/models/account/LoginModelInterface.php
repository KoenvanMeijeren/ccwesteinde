<?php


namespace App\contracts\models\account;

interface LoginModelInterface
{
    /**
     * Construct the model.
     */
    public function __construct();

    /**
     * Check if the user is logged in.
     *
     * @return bool
     */
    public function check();
}
