<?php

namespace server\controllers;


class Category extends BaseModel
{

    private $tableName = 'category';

    private $name;

    private $hexColor; //todo: nice to have

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }

}