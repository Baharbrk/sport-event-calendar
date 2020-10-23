<?php

namespace server\controllers;


class FilterEventController extends BaseModel
{
    private $categoryId;

    /**
     * FilterEventController constructor.
     * @param string $categoryId
     */
    public function __construct(string $categoryId)
    {
        parent::__construct();
        $this->categoryId = $categoryId;
    }

    public function filterEventsByCategory()
    {
        if (isset($_GET['category_id'])) {
            $event = new Event();
            return $event->getEvent(true, $_GET['category_id']);
        }

        return 'Please provide an event Id';
    }
}