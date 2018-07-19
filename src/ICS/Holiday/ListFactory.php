<?php

namespace Natuelabs\BusinessCalendar\ICS\Holiday;

use Natuelabs\BusinessCalendar;
use Natuelabs\BusinessCalendar\ICS;

/**
 * Class ListFactory
 * @package Natuelabs\BusinessCalendar\ICS\Holiday
 */
class ListFactory implements BusinessCalendar\Holiday\ListFactory
{
    private $holidays = [];

    /**
     * ListFactory constructor.
     * @param $icsData
     */
    public function __construct($icsData)
    {
        $this->holidays = ICS\Parser::parse($icsData);
    }

    /**
     * @return array|null|string|string[]
     */
    public function createHolidaysList()
    {
        return $this->holidays;
    }
}