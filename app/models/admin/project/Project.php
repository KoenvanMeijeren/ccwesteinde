<?php


namespace App\model\admin\project;

use App\contracts\models\Model;
use App\model\admin\page\GetFile;
use App\services\core\Request;
use App\services\core\Router;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class Project implements Model
{
    /**
     * The project id.
     *
     * @var int
     */
    protected $id = 0;

    /**
     * The thumbnail file id.
     *
     * @var int
     */
    protected $thumbnailID;

    /**
     * The banner file id.
     *
     * @var int
     */
    protected $bannerID;

    /**
     * The header file id.
     *
     * @var int
     */
    protected $headerID;

    /**
     * The project title.
     *
     * @var string
     */
    protected $title = '';

    /**
     * The project content.
     *
     * @var string
     */
    protected $content = '';

    /**
     * Construct the page.
     */
    public function __construct()
    {
        $request = new Request();
        $this->id = intval(Router::getWildcard());
        $thumbnail = new GetFile($request->post('thumbnail'));
        $this->thumbnailID = $thumbnail->getID();
        $banner = new GetFile($request->post('banner'));
        $this->bannerID = $banner->getID();
        $header = new GetFile($request->post('header'));
        $this->headerID = $header->getID();
        $this->title = $request->post('title');
        $this->content = $request->post('content');
    }

    /**
     * Get the project by id.
     *
     * @return object
     */
    public function get()
    {
        $project = DB::table('project', 3)
            ->select(
                'project_ID',
                'project_thumbnail_ID',
                'fileA.file_path AS project_thumbnail_path',
                'project_banner_ID',
                'fileC.file_path AS project_banner_path',
                'project_header_ID',
                'fileB.file_path AS project_header_path',
                'project_title',
                'project_content'
            )
            ->innerJoin('file AS fileA', 'project_thumbnail_ID', 'fileA.file_ID')
            ->innerJoin('file AS fileB', 'project_header_ID', 'fileB.file_ID')
            ->innerJoin('file AS fileC', 'project_banner_ID', 'fileC.file_ID')
            ->where('project_ID', '=', $this->id)
            ->where('project_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->where('fileC.file_is_deleted', '=', 0)
            ->execute()
            ->first();

        return $project;
    }

    /**
     * Get the first three projects
     *
     * @return array
     */
    public function getFirstThree()
    {
        $projects = DB::table('project', 3)
            ->select(
                'project_ID',
                'project_thumbnail_ID',
                'fileA.file_path AS project_thumbnail_path',
                'project_banner_ID',
                'fileC.file_path AS project_banner_path',
                'project_header_ID',
                'fileB.file_path AS project_header_path',
                'project_title',
                'project_content'
            )
            ->innerJoin('file AS fileA', 'project_thumbnail_ID', 'fileA.file_ID')
            ->innerJoin('file AS fileB', 'project_header_ID', 'fileB.file_ID')
            ->innerJoin('file AS fileC', 'project_banner_ID', 'fileC.file_ID')
            ->where('project_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->where('fileC.file_is_deleted', '=', 0)
            ->orderBy('DESC', 'project_ID')
            ->limit(3)
            ->execute()
            ->all();

        return $projects;
    }

    /**
     * Get all the projects.
     *
     * @return array
     */
    public function getAll()
    {
        $projects = DB::table('project', 3)
            ->select(
                'project_ID',
                'project_thumbnail_ID',
                'fileA.file_path AS project_thumbnail_path',
                'project_banner_ID',
                'fileC.file_path AS project_banner_path',
                'project_header_ID',
                'fileB.file_path AS project_header_path',
                'project_title',
                'project_content'
            )
            ->innerJoin('file AS fileA', 'project_thumbnail_ID', 'fileA.file_ID')
            ->innerJoin('file AS fileB', 'project_header_ID', 'fileB.file_ID')
            ->innerJoin('file AS fileC', 'project_banner_ID', 'fileC.file_ID')
            ->where('project_is_deleted', '=', 0)
            ->where('fileA.file_is_deleted', '=', 0)
            ->where('fileB.file_is_deleted', '=', 0)
            ->where('fileC.file_is_deleted', '=', 0)
            ->orderBy('DESC', 'project_ID')
            ->execute()
            ->all();

        return $projects;
    }

    /**
     * Soft delete a project by id.
     *
     * @return bool
     */
    public function softDelete()
    {
        $softDeleted = DB::table('project')
            ->softDelete('project_is_deleted')
            ->where('project_ID', '=', $this->id)
            ->execute()
            ->isSuccessful();

        if ($softDeleted && empty($this->get())) {
            Session::flash('success', Translation::get('project_successful_deleted'));
            return true;
        }

        Session::flash('error', Translation::get('project_unsuccessful_deleted'));
        return false;
    }
}
