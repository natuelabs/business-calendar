<?php

namespace Natuelabs\BusinessCalendar\Tests\Unit\ICS\Holiday;

use Natuelabs\BusinessCalendar\ICS;
use Natuelabs\BusinessCalendar\Tests\Unit;

/**
 * Class ListFactoryTest
 * @package Natuelabs\BusinessCalendar\Tests\Unit\ICS\Holiday
 */
class ListFactoryTest extends Unit\Holiday\ListFactoryTest
{
    /**
     * @return string
     */
    protected function getICSData()
    {
        return file_get_contents('./data/BrazilHolidaysByGoogle.ics');
    }

    /**
     * @return string[]
     */
    protected function expectedHolidayList()
    {
        return ICS\Parser::parse($this->getICSData());
    }

    /**
     * @return \Natuelabs\BusinessCalendar\Holiday\ListFactory|ICS\Holiday\ListFactory
     */
    protected function createFactory()
    {
        return new ICS\Holiday\ListFactory($this->getICSData());
    }
}