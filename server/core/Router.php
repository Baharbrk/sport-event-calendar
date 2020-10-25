<?php

namespace core;

use app\controllers\EventsController;
use app\controllers\TeamController;


class Router
{
    /**
     * @param string $url
     * @return bool|string
     */
    public function route(string $url)
    {
        if (preg_match('~\/events~', $url)) {
            $eventsController = new EventsController();

            if (!empty(explode('/', $url)[2])) {
                switch (explode('/', $url)[2]) {
                    case 'add':

                        return $eventsController->addEvent();
                    case 'delete':

                        return $eventsController->deleteEvent();
                    case 'update':

                        return $eventsController->updateEvent();
                }
            } else {

                return $eventsController->getEvents();
            }
        } elseif (preg_match('~\/team~', $url)) {
            $teamController = new TeamController();

            return $teamController->filterTeamsByCategory();
        }
        http_response_code(404);

        return 'Page Not Found';
    }
}



