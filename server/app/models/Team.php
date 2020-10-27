<?php

namespace app\models;


use PDO;
use PDOException;

class Team extends BaseModel
{
    /** @var string */
    protected $tableName = 'team';

    public function getCategoryIdByTeamId(string $teamId)
    {
        try {
            $selectQuery = <<<SQL
            SELECT _category_id from team
            WHERE id = :id
            SQL;

            $stmt = $this->conn->prepare($selectQuery);
            $stmt->bindValue(':id', $teamId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchColumn();
        } catch(PDOException $e) {
            echo 'Unable to get Category Id from Teams' . $e->getMessage();
        }
    }

    public function getTeamsByCategoryId(string $categoryId)
    {
        try {
            $selectQuery = <<<SQL
            SELECT id,name from team As t
            WHERE t._category_id = :category_id
            SQL;

            $stmt = $this->conn->prepare($selectQuery);
            $stmt->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Unable to get Teams names and  Ids by their categories' . $e->getMessage();
        }
    }
}