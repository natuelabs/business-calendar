<?php

namespace Natuelabs\BusinessCalendar\Tests\Unit\ICS;

use Natuelabs\BusinessCalendar\ICS;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParserMozzilaBrazilianHolidays()
    {
        $icsData = file_get_contents('./data/BrazilHolidaysByGoogle.ics');
        $holidays = ICS\Parser::parse($icsData);

        $this->assertCount(72, $holidays);
        $this->assertContains('2018-09-07', $holidays);
        $this->assertContains('2019-12-31', $holidays);
        $this->assertContains('2017-12-31', $holidays);
    }
}