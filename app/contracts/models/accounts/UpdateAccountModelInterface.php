<?php


namespace App\contracts\models\accounts;

use App\model\admin\accounts\Account;

interface UpdateAccountModelInterface
{
    /**
     * Construct the account.
     *
     * @param Account $account The account.
     */
    public function __construct(Account $account);

    /**
     * Update the account.
     *
     * @return bool
     */
    public function execute();
}
