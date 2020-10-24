<?php

namespace app\models;


class Category extends BaseModel
{

    /** @var string */
    private $tableName = 'category';

    /** @var string */
    private $name;

    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }
}