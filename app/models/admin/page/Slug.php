<?php


namespace App\model\admin\page;

use App\contracts\models\Model;
use App\services\database\DB;

class Slug implements Model
{
    /**
     * The id of the slug.
     *
     * @var int
     */
    public $id = 0;

    /**
     * The name of the slug.
     *
     * @var string
     */
    public $name = '';

    /**
     * Construct the slug.
     *
     * @param mixed $id       The id of the slug.
     * @param mixed $name     The name of the slug.
     * @param bool  $makeSlug Determine if the slug must be created.
     */
    public function __construct($id, $name, bool $makeSlug = false)
    {
        $this->id = intval($id);
        $this->name = str_replace(' ', '-', strval(strtolower($name)));

        if (empty($this->getByName()) && $makeSlug) {
            $makeSlug = new MakeSlug($this->name);
            $id = $makeSlug->execute();
            $this->id = $id;
        }

        if (empty($this->id)) {
            $slug = $this->getByName();
            $this->id = $slug->slug_ID ?? 0;
        }
    }

    /**
     * Get the slug object.
     *
     * @return object.
     */
    public function get()
    {
        $slug = DB::table('slug')
            ->select('slug_ID', 'slug_name')
            ->where('slug_ID', '=', $this->id)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $slug;
    }

    public function getByName()
    {
        $slug = DB::table('slug')
            ->select('slug_ID', 'slug_name')
            ->where('slug_name', '=', $this->name)
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $slug;
    }

    /**
     * Get all slugs.
     *
     * @return array
     */
    public function getAll()
    {
        $slugs = DB::table('slug')
            ->select('slug_ID', 'slug_name')
            ->where('slug_is_deleted', '=', 0)
            ->execute()
            ->toArray();

        return $slugs;
    }

    /**
     * Soft delete the slug.
     *
     * @return bool
     */
    public function softDelete()
    {
        $isDeleted = DB::table('slug')
            ->softDelete('slug_is_deleted', 1)
            ->execute()
            ->isSuccessful();

        return $isDeleted;
    }
}
