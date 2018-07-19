<?php

namespace Natuelabs\BusinessCalendar\Holiday;


interface ListFactory
{
    /**
     * Return a holiday list
     * @return string[]
     */
    public function createHolidaysList();
}