<?php

namespace server\controllers;


class FilterEventController
{
    /**
     * @return array|string
     */
    public function filterEventsByCategory()
    {
        if (isset($_GET['category_id'])) {
            $event = new Event();
            return $event->getEvent(true, $_GET['category_id']);
        }

        return 'Please provide an event Id';
    }
}