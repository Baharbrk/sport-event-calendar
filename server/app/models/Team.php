<?php

namespace app\models;


class Team extends BaseModel
{
    /** @var string */
    private $tableName = 'team';

    /** @var string */
    private $name;


    public function __construct(string $name)
    {
        parent::__construct();
        $this->name = $name;
    }
}