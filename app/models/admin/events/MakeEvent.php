<?php


namespace App\model\admin\events;

use App\contracts\models\EditModel;
use App\services\core\Translation;
use App\services\database\DB;
use App\services\session\Session;
use Cake\Chronos\Chronos;

class MakeEvent extends Event implements EditModel
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
            $lastInsertedId = DB::table('event')
                ->insert($this->parameters)
                ->execute()
                ->getLastInsertedId();
            $this->id = $lastInsertedId;

            if (!empty($this->get())) {
                Session::flash('success', Translation::get('event_successfully_created'));
                return true;
            }

            Session::flash('error', Translation::get('event_unsuccessfully_created'));
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
            $this->parameters['event_thumbnail_ID'] = intval($this->thumbnailID);
            $this->parameters['event_banner_ID'] = intval($this->bannerID);
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
            || empty($this->location)
            || empty($this->startDatetime)
            || empty($this->endDatetime)
            || empty($this->maximumSignUps)
        ) {
            Session::flash('error', Translation::get('form_message_for_required_fields'));
            return false;
        }

        $startDate = new Chronos($this->startDatetime);
        $endDate = new Chronos($this->endDatetime);

        if ($startDate->isPast() || $endDate->isPast() || $startDate->toTimeString() === $endDate->toTimeString()) {
            Session::flash('error', Translation::get('date_cannot_be_earlier_than_today_or_be_the_same'));
            return false;
        }

        if (empty($this->thumbnailID)
            || empty($this->bannerID)
        ) {
            return false;
        }

        return true;
    }
}
