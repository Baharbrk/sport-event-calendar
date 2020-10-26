<?php


namespace app\controllers;


use app\models\Event;
use app\models\Team;
use app\models\EventsTeams;

class EventsController extends BaseController
{
    /** @var Event */
    private $events;

    public function __construct()
    {
        $this->events = new Event();
    }

    /**
     *
     * @return bool|string
     */
    public function getEvents()
    {
        if (isset($_GET['category_id'])) {

            return $this->filterEventsByCategory();
        }

        return $this->sendResponse($this->events->getEvents(false));
    }

    /**
     *
     * @return bool|string
     */
    public function filterEventsByCategory()
    {
        if (!empty($_GET['category_id'])) {

            return $this->sendResponse($this->events->getEvents(true, $_GET['category_id']));
        }

        return $this->sendError(400, 'Please Provide a Category Id');
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

            $eventId            = $this->events->addEvent($_POST['date'], $categoryId);
            $team               = new Team();
            $homeTeamCategoryId = $team->getCategoryIdByTeamId($homeTeamId);
            $awayTeamCategoryId = $team->getCategoryIdByTeamId($awayTeamId);

            if (!empty($eventId) &&
                $this->validate($homeTeamId, $awayTeamId, $homeTeamCategoryId, $awayTeamCategoryId)
            ) {
                $eventsTeams = new EventsTeams();
                $response    = $eventsTeams->addEventDetails($eventId, $homeTeamId, $awayTeamId);
                if ($response) {

                    return $this->sendOK();
                }

                return $this->sendError(500, 'Unable to add Event');
            }

            return $this->sendError(400, 'Unable to add Event please enter valid teams');

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
    public function updateEvent()
    {
        if (isset($_POST['id'])) {
            $response = $this->events->updateEvent($_POST['id'], $_POST['date']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, 'Unable to update Events');
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }

    /**
     * @return bool
     */
    public function deleteEvent()
    {
        if (isset($_POST['event_id'])) {
            $response = $this->events->deleteEvent($_POST['event_id']);
            if ($response) {

                return $this->sendOK();
            }

            return $this->sendError(500, 'Unable to delete Events');
        }

        return $this->sendError(400, 'Please Provide an event Id');
    }
}