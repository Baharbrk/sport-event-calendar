<?php

namespace server\controllers;


class GetEventController
{

    /**
     *
     * @return array
     */
    public function getEvent()
    {
        $events = new Event();

        return $events->getEvent(false);
    }
}