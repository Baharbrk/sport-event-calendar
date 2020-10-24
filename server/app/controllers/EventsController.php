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
     * @return array
     */
    public function getEvent()
    {
        $events = new Event();

        return json_encode($events->getEvent(false));
    }

    /**
     *
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
                return $eventsTeams->addEventDetails($eventId, $homeTeamId, $awayTeamId);
            }
        } else {
            echo 'Please Provide all needed infos';
        }
    }

    /**
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
    public function updateEvent()
    {
        if (isset($_POST['id'])) {
            $event = new Event();
            return $event->updateEvent($_POST['id'], $_POST['date']);
        }
    }

    /**
     *
     * @return array|string
     */
    public function filterEventsByCategory()
    {
        if (isset($_GET['category_id'])) {
            $event = new Event();
            return json_encode($event->getEvent(true, $_GET['category_id']));
        }

        return 'Please provide an event Id';
    }

    /**
     *
     * @return bool|string
     */
    public function deleteEvent()
    {
        if (isset($_POST['event_id'])) {
            $event = new Event();
            return $event->deleteEvent($_POST['event_id']); // todo: check what it returns?
        }

        return 'Please provide an event Id';
    }
}