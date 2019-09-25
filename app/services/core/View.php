<?php


namespace App\services\core;

class View
{
    /**
     * Load a view and return it.
     *
     * @param string $name The name of the view.
     * @param mixed  $data The data to be used in the view.
     */
    public function __construct(string $name, $data = null)
    {
        loadFile(RESOURCES_PATH . "/views/{$name}.view.php", $data);
    }
}
