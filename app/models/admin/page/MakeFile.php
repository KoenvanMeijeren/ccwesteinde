<?php


namespace App\model\admin\page;

use App\contracts\models\EditModel;
use App\services\database\DB;

class MakeFile implements EditModel
{
    /**
     * The file to be created.
     *
     * @var File
     */
    private $path;

    /**
     * The parameters to be inserted.
     *
     * @var array
     */
    private $parameters;

    /**
     * Construct the file.
     *
     * @param string $path The file path.
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Execute the making of the file.
     */
    public function execute()
    {
        if ($this->prepare()) {
            $inserted = DB::table('file')
                ->insert($this->parameters)
                ->execute()
                ->isSuccessful();

            return $inserted;
        }

        return false;
    }

    /**
     * Prepare the making of the file.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['file_path'] = $this->path;

            return true;
        }

        return false;
    }

    /**
     * Validate the input.
     *
     * @return bool
     */
    private function validate()
    {
        if (empty($this->path)) {
            return false;
        }

        if (!is_string($this->path)) {
            return false;
        }

        return true;
    }
}
