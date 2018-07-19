<?php

namespace Natuelabs\BusinessCalendar\Tests\Unit\Holiday;

use Natuelabs\BusinessCalendar\Holiday;

abstract class ListFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return string[]
     */
    protected abstract function expectedHolidayList();

    /**
     * @return Holiday\ListFactory
     */
    protected abstract function createFactory();

    public function testCreateCalendar()
    {
        $holidays = $this->createFactory()->createHolidaysList();

        $this->assertEquals($this->expectedHolidayList(), $holidays);
    }
}