<?php

namespace core;

use app\controllers\EventsController;


class Router
{
    /**
     * @param string $url
     * @return array|bool|string|void
     */
    public function route(string $url)
    {
        if (preg_match('~\/events~', $url)) {
            $controller = new EventsController();

            if (!empty(explode('/', $url)[2])) {
                switch (explode('/', $url)[2]) {
                    case 'add':

                        return $controller->addEvent();
                    case 'delete':

                        return $controller->deleteEvent();
                    case 'update':

                        return $controller->updateEvent();
                }
            } else {
                return $controller->getEvents();
            }
        } else {
            http_response_code(404);

            return 'Page Not Found';
        }
    }
}



