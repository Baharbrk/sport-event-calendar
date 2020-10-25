<?php


namespace app\controllers;


use app\models\Category;
use app\models\Event;
use app\models\EventsTeams;
use app\models\Team;

class EventsController
{

    /**
     *
     * @return bool|string
     */
    public function getEvents()
    {
        if (isset($_GET['category_id'])) {
            $this->filterEventsByCategory();
        }
        $events   = new Event();

        return $this->sendResponse($events->getEvent(false));
    }

    /**
     * @param array $response
     * @return bool
     */
    public function sendResponse(array $response)
    {
        echo json_encode($response);  //todo:check if status changes

        return true;
    }

    /**
     * @param int $statusCode
     * @param string $message
     *
     * @return bool
     */
    public function sendError(int $statusCode, string $message)
    {

        http_response_code($statusCode);
        echo json_encode($message);

        return false;
    }

    /**
     * @return bool
     */
    public function addEvent()
    {
        if (isset($_POST['date']) &&
            isset($_POST['category']) &&
            isset($_POST['home_team']) &&
            isset($_POST['away_team'])
        ) {
            $category   = new Category($_POST['category']);
            $categoryId = $category->getId();

            $event   = new Event();
            $eventId = $event->addEvent($_POST['date'], $categoryId);

            $homeTeam   = new Team($_POST['home_team']);
            $awayTeam   = new Team($_POST['away_team']);
            $homeTeamId = $homeTeam->getId();
            $awayTeamId = $awayTeam->getId();

            if (!empty($eventId) && $this->validate($homeTeamId, $awayTeamId)) {
                $eventsTeams = new EventsTeams();
                $response = $eventsTeams->addEventDetails($eventId, $homeTeamId, $awayTeamId);
                if ($response) {
                    return $this->sendOK();
                }

                return $this->sendError(500, $response[2]);
            }
        } else {

            return $this->sendError(400, 'Please Provide all needed infos');
        }
    }

    /**
     * Check if home team is not as same as away team
     *
     * @param $homeTeamId
     * @param $awayTeamId
     * @return bool
     */
    private function validate($homeTeamId, $awayTeamId)
    {
        return $homeTeamId !== $awayTeamId ? true : false;
    }

    /**
     * @return bool
     */
    public function sendOK()
    {
        echo json_encode('OK');

        return true;
    }

    /**
     * @return bool
     */
    public function updateEvent()
    {
        if (isset($_POST['id'])) {
            $event = new Event();
            $response = $event->updateEvent($_POST['id'], $_POST['date']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, $response[2]);
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }

    /**
     *
     * @return bool|string
     */
    public function filterEventsByCategory()
    {
        if (!empty($_GET['category_id'])) {
            $event = new Event();

            return $this->sendResponse($event->getEvent(true, $_GET['category_id']));
        }

        return $this->sendError(400, 'Please Provide a Category Id');
    }

    /**
     * @return bool
     */
    public function deleteEvent()
    {
        if (isset($_POST['event_id'])) {
            $event = new Event();
            $response = $event->deleteEvent($_POST['event_id']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, $response[2]);
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }
}