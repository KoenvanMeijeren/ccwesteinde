<?php


namespace App\contracts\models\account;

interface UpdateUserModelInterface
{
    /**
     * Construct the user to be updated.
     *
     * @param int    $id      The id of the user.
     * @param object $account The account of the user.
     */
    public function __construct(int $id, $account);

    /**
     * Prepare the user to be updated.
     *
     * @return bool
     */
    public function execute();
}
