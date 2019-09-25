<?php


namespace App\model\admin\page;

use App\services\database\DB;

class GetFile
{
    /**
     * The id of the file.
     *
     * @var int
     */
    private $id;

    /**
     * The file to be created.
     *
     * @var string
     */
    private $path;

    /**
     * Construct the file.
     *
     * @param string $path The file path.
     */
    public function __construct(string $path)
    {
        $this->path = $path;

        $file = $this->getByPath();
        $this->id = $file->file_ID ?? 0;
    }

    /**
     * Get a file by path.
     *
     * @return object
     */
    private function getByPath()
    {
        $file = DB::table('file')
            ->select('file_ID', 'file_path')
            ->where('file_path', '=', $this->path)
            ->where('file_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $file;
    }

    /**
     * Get the id of the file.
     *
     * @return int
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * Get the path of the file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
}
