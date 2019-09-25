<?php


namespace App\contracts\models\accounts;

interface AccountModelInterface
{
    /**
     * Construct the account.
     */
    public function __construct();

    /**
     * Get a specific account
     *
     * @return object
     */
    public function get();

    /**
     * Get a specific account by email.
     *
     * @return object|null
     */
    public function getByEmail();

    /**
     * Get all accounts.
     *
     * @return array with accounts.
     */
    public function getAll();

    /**
     * Unblock a specific account.
     *
     * @return bool
     */
    public function unblock();

    /**
     * Soft delete a specific account
     *
     * @return bool
     */
    public function softDelete();
}
