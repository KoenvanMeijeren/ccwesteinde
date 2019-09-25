<?php


namespace App\contracts\models\student;

interface StudentModelInterface
{
    /**
     * Construct the student
     */
    public function __construct();

    /**
     * Get a specific account by email.
     *
     * @return object|null
     */
    public function getByEmail();
}
