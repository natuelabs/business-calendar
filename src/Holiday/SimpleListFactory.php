<?php

namespace Natuelabs\BusinessCalendar\Holiday;


/**
 * Class SimpleListFactory
 * @package Natuelabs\BusinessCalendar\Holiday
 */
class SimpleListFactory implements ListFactory
{
    private $holidays;

    public function __construct(array $holidays)
    {
        $this->holidays = $holidays;
    }

    /**
     * @return string[]
     */
    public function createHolidaysList()
    {
        return $this->holidays;
    }
}