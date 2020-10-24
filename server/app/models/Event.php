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
    public function getEvent(bool $doFilter, string $categoryId = null)
    {
        try {
            $selectQuery = <<<SQL
            SELECT e.date, c.name as category_name, c.hex_color, t1.name as home_team, t2.name as away_team
            FROM events as e
            LEFT JOIN category as c
            ON e._category_id = c.id
            LEFT JOIN events_teams as e_t
            ON e.id = e_t._events_id
            LEFT JOIN team as t1
            ON t1.id = e_t._home_team_id
            LEFT JOIN team as t2
            ON t2.id = e_t._away_team_id
            ORDER BY e.date
            SQL;
            if ($doFilter) {
                $selectQuery .= <<<SQL
            WHERE e._category_id = :category_id
            SQL;
            }
            $stmt = $this->conn->prepare($selectQuery);
            if (isset($categoryId)) {
                $stmt->bindParam('category_id', $categoryId, PDO::PARAM_INT);
            }
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $events;
        } catch (PDOException $e) {
            echo 'Unable to get events ' . $e->getMessage();
        }
    }

    /**
     * Update event's date in events table
     *
     * @param $eventId
     * @param $date
     * @return bool
     */
    public function updateEvent(string $eventId, string $date)
    {
        try {
            $updateQuery = <<<SQL
            UPDATE events AS e
            SET date = :event_date
            WHERE e.id = :event_id; 
            SQL;

            $stmt = $this->conn->prepare($updateQuery);
            $stmt->bindParam('event_date', $date, PDO::PARAM_STR);
            $stmt->bindParam('event_id', $eventId, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            echo 'Unable to update the event with Id' . $eventId . $e->getMessage();
        }
    }

    /**
     * Delete event from events table
     *
     * @param string $eventId
     * @return mixed
     */
    public function deleteEvent(string $eventId)
    {
        try {
            $deleteQuery = <<<SQL
            DELETE FROM events AS e
            WHERE e.id = :event_id;
            SQL;

            $stmt = $this->conn->prepare($deleteQuery);
            $stmt->bindParam('event_id', $eventId, PDO::PARAM_INT);
            $result = $stmt->execute();

            return $result;
        } catch (PDOException $e) {
            echo 'Unable to delete the event with Id ' . $eventId . $e->getMessage();
        }
    }
}