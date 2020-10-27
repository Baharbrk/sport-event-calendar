<?php


namespace app\controllers;


use app\models\Team;

class TeamController extends BaseController
{

    public function filterTeamsByCategory()
    {
        $categoryId = $_POST['category'];
        $team       = new Team();

        $this->sendResponse($team->getTeamsByCategoryId($categoryId));
    }
}