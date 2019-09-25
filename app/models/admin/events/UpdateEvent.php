<?php


namespace App\model\admin\events;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;

class UpdateEvent extends Event implements EditModel
{
    /**
     * The parameters
     *
     * @var array
     */
    private $parameters;

    /**
     * Execute the making of the event.
     *
     * @return bool
     */
    public function execute()
    {
        if ($this->prepare()) {
            $updated = DB::table('event')
                ->update($this->parameters)
                ->where('event_ID', '=', $this->id)
                ->execute()
                ->isSuccessful();

            if ($updated) {
                Session::flash('success', Translation::get('event_successfully_updated'));
                return true;
            }

            Session::flash('error', Translation::get('event_unsuccessfully_updated'));
        }

        return false;
    }

    /**
     * Prepare the making of the event.
     *
     * @return bool
     */
    private function prepare()
    {
        if ($this->validate()) {
            if (!empty($this->thumbnailID)) {
                $this->parameters['event_thumbnail_ID'] = intval($this->thumbnailID);
            }

            if (!empty($this->bannerID)) {
                $this->parameters['event_banner_ID'] = intval($this->bannerID);
            }

            $this->parameters['event_title'] = $this->title;
            $this->parameters['event_content'] = $this->content;
            $this->parameters['event_start_datetime'] = $this->startDatetime;
            $this->parameters['event_end_datetime'] = $this->endDatetime;
            $this->parameters['event_location'] = $this->location;
            $this->parameters['event_maximum_persons'] = $this->maximumSignUps;

            return true;
        }

        return false;
    }

    /**
     * Validate the input
     *
     * @return bool
     */
    private function validate()
    {
        if (empty($this->title)
            || empty($this->content)
            || empty($this->startDatetime)
            || empty($this->endDatetime)
            || empty($this->location)
            || empty($this->maximumSignUps)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        return true;
    }
}
