<?php

namespace server\controllers;


class DeleteEventController extends BaseModel
{

    /**
     *
     * @return bool|string
     */
    public function deleteEvent()
    {
        if (isset($_POST['event_id'])) {
            $event = new Event();
            return $event->deleteEvent($_POST['event_id']); //todo: check what it returns?
        }

        return 'Please provide an event Id';
    }
}