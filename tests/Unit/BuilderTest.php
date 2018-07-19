<?php

namespace Natuelabs\BusinessCalendar\Tests;

use Natuelabs\BusinessCalendar;

class BuilderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $workdays
     * @param \DateTime $date
     * @param boolean $expected
     *
     * @dataProvider differentWorkDaysScenarios
     */
    public function testCreateACalendarWithDifferentWorkDays(array $workdays, \DateTime $date, $expected)
    {
        $calendar = (new BusinessCalendar\Builder())
            ->withWorkDays($workdays)
            ->createCalendar();

        $this->assertEquals($expected, $calendar->isBusinessDay($date));
    }

    /**
     * @param array $holidayListFactories
     * @param string[] $expected
     *
     * @dataProvider holidayListFactoriesProvider
     */
    public function testCreateACalendarWithManyHolidayListFactories(array $holidayListFactories, array $expected)
    {
        $calendar = (new BusinessCalendar\Builder($holidayListFactories))
            ->createCalendar();

        $this->assertAttributeEquals($expected, 'holidays', $calendar);
    }

    public function differentWorkDaysScenarios()
    {
        return [
            [
                [BusinessCalendar\Calendar::FRIDAY, BusinessCalendar\Calendar::THURSDAY],
                new \DateTime('next monday'),
                false
            ],
            [
                [
                    BusinessCalendar\Calendar::SUNDAY,
                    BusinessCalendar\Calendar::MONDAY,
                    BusinessCalendar\Calendar::TUESDAY,
                    BusinessCalendar\Calendar::WEDNESDAY,
                    BusinessCalendar\Calendar::FRIDAY,
                    BusinessCalendar\Calendar::SATURDAY,
                ],
                new \DateTime('next thursday'),
                false
            ],
            [
                [
                    BusinessCalendar\Calendar::SUNDAY,
                    BusinessCalendar\Calendar::SATURDAY,
                ],
                new \DateTime('next sunday'),
                true
            ],
        ];
    }

    public function holidayListFactoriesProvider()
    {
        return [
            [
                [
                    new BusinessCalendar\Holiday\SimpleListFactory(['2018-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2019-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2017-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2016-09-07']),
                ],
                ['2018-09-07', '2019-09-07', '2017-09-07', '2016-09-07']
            ],
            [
                [
                    new BusinessCalendar\Holiday\SimpleListFactory(['2018-09-07', '2019-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2017-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2016-09-07']),
                ],
                ['2018-09-07', '2019-09-07', '2017-09-07', '2016-09-07']
            ],
            [
                [
                    new BusinessCalendar\Holiday\SimpleListFactory(['2017-09-07']),
                    new BusinessCalendar\Holiday\SimpleListFactory(['2018-09-07', '2019-09-07']),
                ],
                ['2017-09-07', '2018-09-07', '2019-09-07']
            ],
        ];
    }
}