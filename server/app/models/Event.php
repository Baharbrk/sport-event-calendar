<?php

namespace app\models;

use PDO;
use PDOException;

class Event extends BaseModel
{

    /**
     * Add event to events table
     *
     * @param $eventDate
     * @param $categoryId
     * @return bool|string
     */
    public function addEvent(string $eventDate, string $categoryId)
    {
        try {
            $insertQuery = <<<SQL
            INSERT INTO events (date, _category_id)
            VALUES (:event_date, :category_id)
            SQL;

            $stmt = $this->conn->prepare($insertQuery);
            $stmt->bindParam('event_date', $eventDate, PDO::PARAM_STR);
            $stmt->bindParam('category_id', $categoryId, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result ? $this->conn->lastInsertId() : '';

        } catch (PDOException $e) {
            echo 'Unable to ad the event ' . $e->getMessage();
        }
    }

    /**
     * Get event from events table
     *
     * @param bool $doFilter
     * @param string|null $categoryId
     * @return array
     */
    public function getEvents(bool $doFilter, string $categoryId = null)
    {
        try {
            $selectQuery = <<<SQL
            SELECT e.id, e.date, c.name as category_name, c.hex_color, t1.name as home_team, t2.name as away_team
            FROM events as e
            JOIN category as c
            ON e._category_id = c.id
            JOIN events_teams as e_t
            ON e.id = e_t._event_id
            JOIN team as t1
            ON t1.id = e_t._home_team_id
            JOIN team as t2
            ON t2.id = e_t._away_team_id
            SQL;
            if ($doFilter) {
                $selectQuery .= <<<SQL
             WHERE e._category_id = :category_id
            SQL;
            }
            $selectQuery .= <<<SQL
              ORDER BY e.date;
            SQL;

            $stmt = $this->conn->prepare($selectQuery);
            if (isset($categoryId)) {
                $stmt->bindParam('category_id', $categoryId, PDO::PARAM_INT);

            }
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Unable to get events ' . $e->getMessage();
        }
    }

    /**
     * Update event's date in events table
     *
     * @param string $eventId
     * @param string $date
     * @return array|bool
     */
    public function updateEvent(string $eventId, string $date)
    {
        try {
            $updateQuery = <<<SQL
            UPDATE events
            SET date = :event_date
            WHERE id = :event_id; 
            SQL;

            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam('event_date', $date, PDO::PARAM_STR);
            $stmt->bindParam('event_id', $eventId, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result ? $result : $stmt->errorInfo();
        } catch (PDOException $e) {
            echo 'Unable to update the event with Id' . $eventId . $e->getMessage();
        }
    }

    /**
     * Delete event from events table
     *
     * @param string $eventId
     * @return array|bool
     */
    public function deleteEvent(string $eventId)
    {
        try {
            $deleteQuery = <<<SQL
            DELETE FROM events
            WHERE id = :event_id;
            SQL;

            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindParam('event_id', $eventId, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result ? $result : $stmt->errorInfo();
        } catch (PDOException $e) {
            echo 'Unable to delete the event with Id ' . $eventId . $e->getMessage();
        }
    }
}