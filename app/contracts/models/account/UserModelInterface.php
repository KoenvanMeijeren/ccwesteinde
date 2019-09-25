<?php


namespace App\contracts\models\account;

interface UserModelInterface
{
    /**
     * Construct the user.
     */
    public function __construct();

    /**
     * Get a specific account.
     *
     * @param int $id The id the user.
     *
     * @return object|null
     */
    public function getAccount(int $id);

    /**
     * Get an specific account by an given email
     *
     * @return object|null
     */
    public function getAccountByEmail();

    /**
     * Get the id of the user.
     *
     * @return int
     */
    public function getID();

    /**
     * Get the rights of the user.
     *
     * @return int
     */
    public function getRights();

    /**
     * Log the user out.
     *
     * @return void
     */
    public function logout();
}
