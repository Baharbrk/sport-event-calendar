<?php

namespace core;

use app\controllers\EventsController;
use app\controllers\TeamController;


class Router
{
    /**
     * @var TeamController
     */
    private $teamController;

    /**
     * @var EventsController
     */
    private $eventsController;

    public function __construct()
    {
        $this->eventsController = new EventsController();
        $this->teamController = new TeamController();
    }

    /**
     * @param string $url
     * @return bool
     */
    public function route(string $url)
    {
        if (preg_match('~\/events~', $url)) {
            if (!empty(explode('/', $url)[2])) {
                switch (explode('/', $url)[2]) {
                    case 'add':
                        $this->eventsController->addEvent();

                        return true;
                    case 'delete':
                        $this->eventsController->deleteEvent();

                        return true;
                    case 'update':
                        $this->eventsController->updateEvent();

                        return true;
                }
            } else {

                $this->eventsController->getEvents();

                return true;
            }
        } elseif (preg_match('~\/team~', $url)) {
            $this->teamController->filterTeamsByCategory();

            return true;
        }
        http_response_code(404);
        echo 'Page Not Found';

        return false;
    }
}



