<?php

namespace Natuelabs\BusinessCalendar\Tests\Unit;

use Natuelabs\BusinessCalendar;


class CalendarTest extends \PHPUnit_Framework_TestCase
{
    public function testIsHolidayWithPreviouslySettedHoliday()
    {
        $calendar = new BusinessCalendar\Calendar([$holiday = '2018-09-07']);

        $this->assertTrue($calendar->isHoliday(new \DateTime($holiday)));
    }

    public function testIsHolidayWithoutPreviouslySettedHoliday()
    {
        $calendar = new BusinessCalendar\Calendar;


        $this->assertFalse($calendar->isHoliday(new \DateTime('2018-09-07')));
    }

    public function testWithHolidayOnEmptyCalendar()
    {
        $calendar = new BusinessCalendar\Calendar;
        $newCalendar = $calendar->withHolidays(['2018-09-07']);

        $this->assertAttributeContains('2018-09-07', 'holidays', $newCalendar);
    }

    public function testWithHolidayOnFilledCalendar()
    {
        $calendar = new BusinessCalendar\Calendar(['2018-09-07']);
        $newCalendar = $calendar->withHolidays(['2018-12-25']);

        $this->assertAttributeEquals([
            '2018-09-07',
            '2018-12-25'
        ], 'holidays', $newCalendar);
    }

    /**
     * @param array $holidays
     * @param string $workDate
     *
     * @dataProvider businessDaysScenarios
     */
    public function testIsBusinessDayWithWorkDays(array $holidays, $workDate)
    {
        $calendar = new BusinessCalendar\Calendar($holidays);

        $this->assertTrue($calendar->isBusinessDay(
            new \DateTime($workDate)
        ));
    }

    /**
     * @param array $holidays
     * @param string $nonWorkDate
     *
     * @dataProvider nonWorkDaysScenarios
     */
    public function testIsBusinessDayInANonWorkDay(array $holidays, $nonWorkDate)
    {
        $calendar = new BusinessCalendar\Calendar($holidays);

        $this->assertFalse($calendar->isBusinessDay(
            new \DateTime($nonWorkDate)
        ));
    }

    /**
     * @param \DateTime $date
     * @param int $businessDays
     * @param string $expected
     * @param array $holidays
     *
     * @dataProvider addingBusinessDaysScenario
     */
    public function testAddBusinessDays(\DateTime $date, $businessDays, $expected, array $holidays = [])
    {
        $calendar = new BusinessCalendar\Calendar($holidays);

        $this->assertEquals(
            $expected,
            $calendar->addBusinessDays($date, $businessDays)->format('Y-m-d')
        );
    }

    /**
     * @param \DateTime $date
     * @param int $businessDays
     * @param string $expected
     * @param array $holidays
     *
     * @dataProvider removingBusinessDaysScenario
     */
    public function testSubBusinessDays(\DateTime $date, $businessDays, $expected, array $holidays = [])
    {
        $calendar = new BusinessCalendar\Calendar($holidays);

        $this->assertEquals(
            $expected,
            $calendar->subBusinessDays($date, $businessDays)->format('Y-m-d')
        );
    }

    public function businessDaysScenarios()
    {
        return [
            [
                [], '2018-07-18'
            ],
            [
                ['2018-12-25'], '2018-12-26'
            ],
            [
                ['2018-12-25'], '2019-12-25'
            ],
        ];
    }

    public function nonWorkDaysScenarios()
    {
        return [
            [
                [], '2018-07-15'
            ],
            [
                ['2018-09-07'], '2018-09-07 00:00:00'
            ],
            [
                ['2018-09-07'], '2018-09-07 23:59:59'
            ],
            [
                ['2018-09-07'], '2019-01-05 23:59:59'
            ],
        ];
    }

    public function addingBusinessDaysScenario()
    {
        return [
            // one holiday and two non work days
            [
                new \DateTime('2018-09-06'), 1, '2018-09-10', ['2018-09-07']
            ],
            // two holidays
            [
                new \DateTime('2018-12-23'), 1, '2018-12-26', ['2018-12-24', '2018-12-25']
            ],
            // three business day
            [
                new \DateTime('2018-12-17'), 3, '2018-12-20', []
            ],
        ];
    }

    public function removingBusinessDaysScenario()
    {
        return [
            // one holiday and two non work days
            [
                new \DateTime('2018-09-10'), 1, '2018-09-06', ['2018-09-07']
            ],
            // two holidays
            [
                new \DateTime('2019-12-26'), 1, '2019-12-23', ['2019-12-24', '2019-12-25']
            ],
            // three business day
            [
                new \DateTime('2018-12-20'), 3, '2018-12-17', []
            ],
        ];
    }
}