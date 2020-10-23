<?php

namespace server\controllers;


use PDO;

class Event extends BaseModel
{
    private $tableName = 'events';

    /** @var  */
    private $id;

    /** @var  */
    private $date;

    /** @var  */
    private $category;

    public function __construct()
    {
        parent::__construct();

    }

    public function addEvent()
    {

    }

    public function getEvent(bool $doFilter, string $categoryId = null)
    {

    }

    public function updateEvent()
    {

    }

    /**
     * @param string $eventId
     * @return mixed
     */
    public function deleteEvent(string $eventId)
    {
        $deleteQuery = <<<SQL
        DELETE FROM events AS e
        WHERE e.id = :event_id;
        SQL;

        $stmt = $this->conn->prepare($deleteQuery);
        $stmt->bindParam('event_id' , $eventId , PDO::PARAM_INT);
        $result = $stmt->execute();

        return $result;
    }
}