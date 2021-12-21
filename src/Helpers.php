<?php

namespace Railroad\AddEventSdk;

use Carbon\Carbon;

class Helpers
{
    /**
     * @var string
     */
    protected $apiToken;

    public function __construct()
    {
        $this->apiToken = config('addevent-sdk.api-token');
    }

    /**
     * @param $url
     * @return array|bool|mixed|object
     * @throws \Exception
     */

    /**
     * @param $params
     * @return string
     */
    public static function arrayToQueryString($params)
    {
        $culledParams = [];

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                $culledParams[$key] = $value;
            }
        }

        $queryString = '';

        foreach ($culledParams as $key => $value) {
            $queryString .= '&' . $key . '=' . urlencode($value);
        }

        return $queryString;
    }

    /**
     * @param $result
     * @param $property
     * @throws \Exception
     */
    public static function ensureProperty($result, $property)
    {
        if (gettype($result) !== 'object') {
            throw new \Exception(
                'CURL response is not an object as expected and thus cannot contain the expected property \''
                . $property . '\'. This should be taken as an indication of failure to perform the requested operation.'
            );
        }
        if (!property_exists($result, $property)) {
            throw new \Exception(
                'CURL response did not contain expected property \'' . $property . '\'. This should be ' .
                'taken as an indication of failure to perform the requested operation.'
            );
        }
    }

    /**
     * @param $strOne
     * @param $strTwo
     * @return bool
     */
    public static function stringsSameIfFormattingRemoved($strOne, $strTwo)
    {
        $clean = function ($str) {
            return preg_replace(
                '/[^a-zA-Z0-9]/',
                '',
                str_replace(["&nbsp;", "\r", "\n", "\t", '\n', '\r', '\t'], '', $str)
            );
        };

        $cleanStrOne = $clean($strOne);
        $cleanStrTwo = $clean($strTwo);

        return $cleanStrOne === $cleanStrTwo;
    }

    /**
     * @param $event
     * @param $startDate
     * @param null $endDate
     * @return bool
     * @throws \Exception
     */
    public static function timesMatch($event, $startDate, $endDate = null)
    {
        $tz = empty($event->timezone) ? 'Europe/London' : $event->timezone;

        $startFromEvent = self::getTimeFromEvent($event);
        $startFromEventTimestamp = $startFromEvent->timestamp;
        $expected = Carbon::parse($startDate, $tz);
        if ($event->all_day_event === 'true') {
            $expected->hour = 0;
            $expected->minute = 0;
            $expected->second = 0;
        }
        $expectedTimestamp = $expected->timestamp;

        if ($endDate) {
            $endFromEvent = self::getTimeFromEvent($event, true);
            $endFromEventTimestamp = $endFromEvent->timestamp;
            $expectedEnd = Carbon::parse($endDate, $tz);
            if ($event->all_day_event === 'true') {
                $expectedEnd->hour = 0;
                $expectedEnd->minute = 0;
                $expectedEnd->second = 0;
            }
            $expectedEndTimestamp = $expectedEnd->timestamp;
            return $startFromEventTimestamp === $expectedTimestamp && $endFromEventTimestamp === $expectedEndTimestamp;
        }
        return $startFromEventTimestamp === $expectedTimestamp;
    }

    /**
     * @param $event
     * @param bool $getEnd
     * @return Carbon
     * @throws \Exception
     */
    private static function getTimeFromEvent($event, $getEnd = false)
    {
        if ($event->date_format !== 'MM/DD/YYYY') {
            throw new \Exception(
                'Unexpected data_format in event. "' . $event->date_format . '" (event id: "' . $event->id . '")'
            );
        }

        $date = $event->date_start;
        $time = $event->date_start_time;
        if ($getEnd) {
            $date = $event->date_end;
            $time = $event->date_end_time;
        }

        $year = substr($date, 6, 4);
        $month = substr($date, 0, 2);
        $day = substr($date, 3, 2);

        $hour = substr($time, 0, 2);
        $minute = substr($time, 3, 2);
        $second = substr($time, 5, 2);

        $year = (int)$year;
        $month = (int)$month;
        $day = (int)$day;

        $hour = (int)$hour;
        $minute = (int)$minute;
        $second = (int)$second;

        $tz = empty($event->timezone) ? 'Europe/London' : $event->timezone;

        return Carbon::create($year, $month, $day, $hour, $minute, $second, $tz);
    }

}