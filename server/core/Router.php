<?php

namespace server\core;

use app\controllers\EventsController;


class Router
{
    /**
     * @param string $url
     * @return array|bool|string|void
     */
    public function route(string $url)
    {
        $controller = new EventsController();

        if (isset($_GET['category_id'])) {

            return $controller->filterEventsByCategory();
        } else {

            switch (explode('/', $url)[2]) {
                case 'add':

                    return $controller->addEvent();
                case 'delete':

                    return $controller->deleteEvent();
                case 'update':

                    return $controller->updateEvent();
                default:

                    return $controller->getEvent(); //todo: maybe add a home controller?
            }
        }
    }
}
