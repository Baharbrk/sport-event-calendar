<?php

namespace app\models;


use PDO;

class Team extends BaseModel
{
    /** @var string */
    protected $tableName = 'team';


    public function getCategoryIdFromTeam(string $teamId)
    {
        $selectQuery = <<<SQL
            SELECT _category_id from team
            WHERE id = :id
            SQL;

        $stmt = $this->conn->prepare($selectQuery);
        $stmt->bindValue(':id', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}