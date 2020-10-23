<?php

namespace server\core;

use server\controllers\AddEventController;
use server\controllers\DeleteEventController;
use server\controllers\FilterEventController;
use server\controllers\GetEventController;
use server\controllers\UpdateEventController;

class Router
{
    /**
     * @param string $url
     * @return array|bool|string|void
     */
    public function route(string $url)
    {
        if (isset($_GET['category_id'])) {
            $controller = new FilterEventController();

            return $controller->filterEventsByCategory();
        } else {
            switch (explode('/', $url)[2]) {
                case 'add':
                    $controller = new AddEventController();

                    return $controller->addEvent();
                case 'delete':
                    $controller = new DeleteEventController();

                    return $controller->deleteEvent();
                case 'update':
                    $controller = new UpdateEventController();

                    return $controller->updateEvent();
                default:
                    $controller = new GetEventController();

                    return $controller->getEvent();
            }
        }
    }
}
