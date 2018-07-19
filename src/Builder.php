<?php

namespace Natuelabs\BusinessCalendar;


/**
 * Class Builder
 * @package Natuelabs\BusinessCalendar
 */
class Builder
{
    private $workDays = [];
    private $holidayListFactories;

    /**
     * Builder constructor.
     * @param Holiday\ListFactory[] $holidayListFactories
     */
    public function __construct(array $holidayListFactories = [])
    {
        $this->holidayListFactories = $holidayListFactories;
    }

    /**
     * @param array $workDays
     * @return $this
     */
    public function withWorkDays(array $workDays)
    {
        $this->workDays = $workDays;

        return $this;
    }

    /**
     * @return string[]
     */
    private function holidayList()
    {
        $holidays = [];
        foreach ($this->holidayListFactories as $factory) {
            $holidays = array_merge($holidays, $factory->createHolidaysList());
        }

        return array_unique($holidays);
    }

    /**
     * @return Calendar
     */
    public function createCalendar()
    {
        $holidays = $this->holidayList();

        if ($this->workDays) {
            return new Calendar($holidays, $this->workDays);
        }

        return new Calendar($holidays);
    }
}