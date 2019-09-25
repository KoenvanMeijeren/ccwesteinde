<?php


namespace App\contracts\models\accounts;

use App\model\admin\accounts\Account;

interface MakeAccountModelInterface
{
    /**
     * Insert the account.
     *
     * @return bool
     */
    public function execute();
}
