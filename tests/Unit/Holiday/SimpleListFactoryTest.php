<?php

namespace Natuelabs\BusinessCalendar\Tests\Unit\Holiday;

use Natuelabs\BusinessCalendar\Holiday;

class SimpleListFactoryTest extends ListFactoryTest
{
    /**
     * @return string[]
     */
    protected function expectedHolidayList()
    {
        return ['2018-09-07', '2018-12-25', '2018-12-31'];
    }

    /**
     * @return Holiday\ListFactory|Holiday\SimpleListFactory
     */
    protected function createFactory()
    {
        return new Holiday\SimpleListFactory($this->expectedHolidayList());
    }
}