<?php

namespace Natuelabs\BusinessCalendar;


/**
 * Class Calendar
 * @package Natuelabs\BusinessCalendar
 */
class Calendar
{
    const SUNDAY    = 0;
    const MONDAY    = 1;
    const TUESDAY   = 2;
    const WEDNESDAY = 3;
    const THURSDAY  = 4;
    const FRIDAY    = 5;
    const SATURDAY  = 6;

    private $holidays;
    private $workDays = [
        self::MONDAY,
        self::TUESDAY,
        self::WEDNESDAY,
        self::THURSDAY,
        self::FRIDAY
    ];

    /**
     * Calendar constructor.
     * @param array $holidays
     * @param array $workDays
     */
    public function __construct(array $holidays = [], array $workDays = [])
    {
        $this->holidays = $holidays;

        if (!empty($workDays)) {
            $this->workDays = $workDays;
        }
    }

    /**
     * @param \DateTime $holiday
     * @return bool
     */
    public function isHoliday(\DateTime $holiday)
    {
        return in_array($holiday->format('Y-m-d'), $this->holidays);
    }

    /**
     * @param array $holidays
     * @return Calendar
     */
    public function withHolidays(array $holidays)
    {
        return new Calendar(array_merge($this->holidays, $holidays));
    }

    /**
     * @param \DateTime $dateTime
     * @return bool
     */
    public function isBusinessDay(\DateTime $dateTime)
    {
        if (in_array($dateTime->format('Y-m-d'), $this->holidays)) {
            return false;
        }

        return in_array($dateTime->format('w'), $this->workDays);
    }

    /**
     * @param \DateTime $date
     * @param int $businessDays
     * @return \DateTime
     */
    public function addBusinessDays(\DateTime $date, $businessDays)
    {
        while ($businessDays) {
            $date->add(new \DateInterval('P1D'));

            if ($this->isBusinessDay($date)) {
                $businessDays--;
            }
        }

        return $date;
    }

    /**
     * @param \DateTime $date
     * @param int $businessDays
     * @return \DateTime
     */
    public function subBusinessDays(\DateTime $date, $businessDays)
    {
        while ($businessDays) {
            $date->sub(new \DateInterval('P1D'));

            if ($this->isBusinessDay($date)) {
                $businessDays--;
            }
        }

        return $date;
    }
}