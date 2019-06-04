<?php

namespace Railroad\AddEventSdk;

use Carbon\Carbon;

class Helper
{
    /**
     * @param $url
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function curl($url)
    {
        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, $url);
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);
        if (empty($buffer)) {
            return false;
        }
        $result = json_decode($buffer);

        $status = $result->meta->code;

        if ($status !== '200') {
            throw new \Exception('AddEventService CURL request response status *not* 200');
        }

        return $result;
    }

    /**
     * @param $params
     * @return string
     */
    public function arrayToQueryString($params)
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
    public function ensureProperty($result, $property)
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
    public function stringsSameIfFormattingRemoved($strOne, $strTwo)
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
    public function timesMatch($event, $startDate, $endDate = null)
    {
        $tz = empty($event->timezone) ? 'Europe/London' : $event->timezone;

        $startFromEvent = $this->getTimeFromEvent($event);
        $startFromEventTimestamp = $startFromEvent->timestamp;
        $expected = Carbon::parse($startDate, $tz);
        if ($event->all_day_event === 'true') {
            $expected->hour = 0;
            $expected->minute = 0;
            $expected->second = 0;
        }
        $expectedTimestamp = $expected->timestamp;

        if ($endDate) {
            $endFromEvent = $this->getTimeFromEvent($event, true);
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
     * @return void
     *
     * if this method is called, then all subsequent actions by this class will only operate on sandbox calendars
     */
    public function useSandbox()
    {
        $this->sandboxIfSet = 'sandbox_';
    }

    /**
     * @param $event
     * @param bool $getEnd
     * @return Carbon
     * @throws \Exception
     */
    private function getTimeFromEvent($event, $getEnd = false)
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
