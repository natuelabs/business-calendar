<?php

namespace Natuelabs\BusinessCalendar\ICS;


/**
 * Class Parser
 * @package Natuelabs\BusinessCalendar\ICS
 */
class Parser
{
    /**
     * @param $content
     * @return null|string|string[]
     */
    public static function parse($content)
    {
        $ics = explode("\n", $content);
        $ics = preg_grep('/^DTSTART;/', $ics);

        return preg_replace('/^DTSTART;VALUE=DATE:(\\d{4})(\\d{2})(\\d{2}).*/s', '$1-$2-$3', $ics);
    }
}