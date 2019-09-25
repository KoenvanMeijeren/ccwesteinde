<?php


namespace App\model\admin\page;

use App\contracts\models\EditModel;
use App\services\database\DB;

class MakeSlug implements EditModel
{
    /**
     * The slug name.
     *
     * @var string
     */
    private $name;

    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Construct the slug.
     *
     * @param mixed $name The slug name.
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Execute the making of the slug.
     *
     * @return int
     */
    public function execute()
    {
        if ($this->prepare()) {
            $lastInsertedID = DB::table('slug')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();

            return $lastInsertedID;
        }

        return 0;
    }

    /**
     * Prepare the slug to be inserted.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            $this->parameters['slug_name'] = $this->name;

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
        if (empty($this->name)) {
            return false;
        }

        if (!is_string($this->name)) {
            return false;
        }

        return true;
    }
}
