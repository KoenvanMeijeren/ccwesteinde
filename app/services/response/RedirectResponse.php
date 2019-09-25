<?php


namespace App\services\response;

use App\services\core\URL;

class RedirectResponse
{
    /**
     * The path to redirect to.
     *
     * @var string
     */
    private $_path;

    /**
     * Construct the path and redirect to the path.
     *
     * @param string $path The path to redirect to.
     */
    public function __construct(string $path)
    {
        $this->_path = $path;

        $this->_redirect();
    }

    /**
     * Redirect the path.
     *
     * @return void
     */
    private function _redirect()
    {
        URL::redirect($this->_path);
    }
}
