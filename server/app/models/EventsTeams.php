<?php


namespace app\models;

use PDO;
use PDOException;

class EventsTeams extends BaseModel
{
    /**
     * Add event's and team's Ids to events_teams table
     *
     * @param $eventId
     * @param $homeTeamId
     * @param $awayTeamId
     * @return bool
     */
    public function addEventDetails(string $eventId, string $homeTeamId, string $awayTeamId)
    {
        try {
            $insertQuery = <<<SQL
            INSERT INTO events_teams (_event_id, _home_team_id, away_team_id)
            VALUES (:event_id, :home_id, :away_id)
            SQL;

            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bindParam('event_id', $eventId, PDO::PARAM_INT);
            $stmt->bindParam('home_id', $homeTeamId, PDO::PARAM_INT);
            $stmt->bindParam('away_id', $awayTeamId, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo 'Unable to add events details to events_teams for event Id ' . $eventId . $e->getMessage();
        }
    }
}