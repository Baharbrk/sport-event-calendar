<?php

namespace server\controllers;


class Team extends BaseModel
{
    private $tableName = 'team';

    private $name;

    private $category;

    public function __construct($name, $category)
    {
        parent::__construct();
        $this->name = $name;
        $this->category = $category;
    }
}