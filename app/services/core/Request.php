<?php


namespace App\services\core;

class Request
{
    /**
     * Get a specific post item.
     *
     * @param string $key The key to search for the corresponding value in the post array.
     *
     * @return mixed
     */
    public function post(string $key)
    {
        if (isset($_POST[$key]) && !empty($_POST[$key])) {
            if (is_scalar($_POST[$key])) {
                $sanitize = new Sanitize($_POST[$key]);
                return $sanitize->data();
            }

            if (is_array($_POST[$key])) {
                return $this->_buildNewArray($key, $_POST);
            }
        }

        return '';
    }

    /**
     * Get a specific get item.
     *
     * @param string $key The key to search for the corresponding value in the get array.
     *
     * @return mixed
     */
    public function get(string $key)
    {
        if (isset($_GET[$key]) && !empty($_GET[$key])) {
            if (is_scalar($_GET[$key])) {
                $sanitize = new Sanitize($_GET[$key]);
                return $sanitize->data();
            }

            if (is_array($_GET[$key])) {
                return $this->_buildNewArray($key, $_GET);
            }
        }

        return '';
    }

    /**
     * Get a specific uploaded file.
     *
     * @param string $key The key to search for the corresponding value in the file array.
     *
     * @return array
     */
    public function file(string $key)
    {
        if (isset($_FILES[$key]) && !empty($_FILES[$key])) {
            return $_FILES[$key];
        }

        return [];
    }

    /**
     * Get all post items which are matching with the given parameters.
     *
     * @param array $parameters The parameters to loop through and search for the corresponding values.
     *
     * @return array
     */
    public function posts(array $parameters)
    {
        $posts = [];
        foreach ($parameters as $parameter) {
            $posts += [$parameter => $this->post($parameter)];
        }

        return $posts;
    }

    /**
     * Build a new array with sanitized values.
     *
     * @param string $key    The key to search for the corresponding value in the array.
     * @param array  $method The array to search for the corresponding value.
     *
     * @return array
     */
    private function _buildNewArray(string $key, array $method)
    {
        $newArray = [];
        foreach ($method[$key] as $post) {
            if (is_scalar($post)) {
                $sanitize = new Sanitize($post);
                $newArray[] = $sanitize->data();
            }
        }

        return $newArray;
    }
}
