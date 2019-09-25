<?php


namespace App\model\admin\page;

use App\contracts\models\Model;
use App\services\core\Upload;
use App\services\database\DB;

class File implements Model
{
    /**
     * The id of the file.
     *
     * @var int
     */
    public $id;

    /**
     * The path of the file.
     *
     * @var string
     */
    public $path;

    /**
     * Construct the file.
     *
     * @param array $file The file.
     */
    public function __construct(array $file)
    {
        $uploader = new Upload($file);

        if (!empty($file)) {
            if ($uploader->prepare() && empty($uploader->getFileIfItExists())) {
                $uploader->execute();

                $this->path = $uploader->getStoredFilePath();
            }
        }

        if (empty($this->path)) {
            $this->path = $uploader->getFileIfItExists();
        }

        if (!empty($this->path) && empty($this->getByPath())) {
            $makeFile = new MakeFile($this->path);
            $makeFile->execute();
        }

        $this->id = $this->getByPath()->file_ID ?? 0;
    }

    /**
     * Get the file by id.
     *
     * @return object.
     */
    public function get()
    {
        $file = DB::table('file')
            ->select('file_ID', 'file_path')
            ->where('file_ID', '=', $this->id)
            ->where('file_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $file;
    }

    /**
     * Get the file by path.
     *
     * @return object
     */
    public function getByPath()
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
     * Get all files.
     *
     * @return array
     */
    public function getAll()
    {
        $files = DB::table('file')
            ->select('file_ID', 'file_path')
            ->where('file_is_deleted', '=', 0)
            ->execute()
            ->toArray();

        return $files;
    }

    /**
     * Soft delete the file.
     *
     * @return bool
     */
    public function softDelete()
    {
        $isDeleted = DB::table('file')
            ->softDelete('file_is_deleted')
            ->where('file_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        return $isDeleted;
    }
}
