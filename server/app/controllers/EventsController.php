<?php


namespace app\controllers;


use app\models\Event;
use app\models\Team;
use app\models\EventsTeams;

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
        $events = new Event();

        return $this->sendResponse($events->getEvents(false));
    }

    /**
     *
     * @return bool|string
     */
    public function filterEventsByCategory()
    {
        if (!empty($_GET['category_id'])) {
            $event = new Event();

            return $this->sendResponse($event->getEvents(true, $_GET['category_id']));
        }

        return $this->sendError(400, 'Please Provide a Category Id');
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
            $categoryId = $_POST['category'];
            $homeTeamId = $_POST['home_team'];
            $awayTeamId = $_POST['away_team'];

            $event              = new Event();
            $eventId            = $event->addEvent($_POST['date'], $categoryId);
            $team               = new Team();
            $homeTeamCategoryId = $team->getCategoryIdFromTeam($homeTeamId);
            $awayTeamCategoryId = $team->getCategoryIdFromTeam($awayTeamId);

            if (
                !empty($eventId) &&
                $this->validate($homeTeamId, $awayTeamId, $homeTeamCategoryId, $awayTeamCategoryId)
            ) {
                $eventsTeams = new EventsTeams();
                $response    = $eventsTeams->addEventDetails($eventId, $homeTeamId, $awayTeamId);
                if ($response) {
                    return $this->sendOK();
                }

                return $this->sendError(500, $response[2]); //this should be changed
            }

            return $this->sendError(400, 'same teams');

        } else {

            return $this->sendError(400, 'Please Provide all needed infos');
        }
    }

    /**
     * Check if home team is not as same as away team
     *
     * @param $homeTeamId
     * @param $awayTeamId
     * @param $homeCategoryId
     * @param $awayCategoryId
     * @return bool
     */
    private function validate(string $homeTeamId, string $awayTeamId, string $homeCategoryId, string $awayCategoryId)
    {
        if ($homeTeamId !== $awayTeamId && $homeCategoryId === $awayCategoryId) {
            return true;
        }

        return false;
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
            $event    = new Event();
            $response = $event->updateEvent($_POST['id'], $_POST['date']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, $response[2]);
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }

    /**
     * @return bool
     */
    public function deleteEvent()
    {
        if (isset($_POST['event_id'])) {
            $event    = new Event();
            $response = $event->deleteEvent($_POST['event_id']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, $response[2]);
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }
}