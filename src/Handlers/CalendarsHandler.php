<?php

namespace Railroad\AddEventSdk\Handlers;

use Railroad\AddEventSdk\Helpers;

/**
 * Class Connector
 * @package Railroad\AddEventSdk
 *
 * See AddEvent docs:
 * addevent.com/api/subscription-calendar
 */
class CalendarsHandler extends Handler
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function list()
    {
        $calendars = [];
        $allRetrieved = false;

        while (!$allRetrieved) {
            $params = ['token' => $this->apiToken];

            $url = 'https://www.addevent.com/api/v1/me/calendars/list/?' . Helpers::arrayToQueryString($params);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            $result = $this->curl($url);
            Helpers::ensureProperty($result, 'calendars');

            $pagingNext = $result->paging->next;
            if (empty($pagingNext)) {
                $allRetrieved = true;
            }
            $calendars = array_merge($calendars, $result->calendars);
        }

        return $calendars;
    }

    /**
     * @param $title
     * @param null $description
     * @return \stdClass
     * @throws \Exception
     */
    public function create($title, $description = null)
    {
        $params = [
            'token' => $this->apiToken, // required
            'title' => $title, // required
            'description' => $description
        ];

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/create/?' . $queryString;

        $result = $this->curl($url);

        Helpers::ensureProperty($result, 'calendar');

        return $result->calendar;
    }

    /**
     * @param $calendarId
     * @param $title
     * @param $description
     * @return mixed
     * @throws \Exception
     */
    public function update($calendarId, $title, $description)
    {
        $params = [
            'token' => $this->apiToken, // required
            'calendar_id' => $calendarId, // required
            'title' => $title, // required
            'description' => $description
        ];

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/save/?' . $queryString;

        $result = $this->curl($url);

        Helpers::ensureProperty($result, 'calendar');

        return $result->calendar;
    }

    /**
     * @param $calendarId
     * @param bool $ensureDeletedWithSecondRequest
     * @return bool
     * @throws \Exception
     */
    public function delete($calendarId, bool $ensureDeletedWithSecondRequest = false)
    {
        $params = [
            'token' => $this->apiToken, // required
            'calendar_id' => $calendarId
        ];

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/delete/?' . $queryString;

        $result = $this->curl($url);

        if (!property_exists($result, 'calendar')) {
            throw new \Exception('deleteCalendar CURL response data missing "calendar" property');
        }

        // $idOfDeleted = $result->calendar->id;
        $deleted = $result->calendar->status === 'deleted';

        if ($ensureDeletedWithSecondRequest) {
            foreach ($this->list() as $calendar) {
                $existentCalendarId = (int)$calendar->id;
                $targetCalendarId = (int)$calendarId;
                if ($existentCalendarId === $targetCalendarId) {
                    $deleted = false;
                }
            }
        }

        if (!$deleted) {
            throw new \Exception(
                'deleteCalendar failed for calendar id ' . $calendarId . '. CURL response: "' .
                var_export($result, true) . '"'
            );
        }

        return true;
    }

//    /**
//     * @return array|bool|mixed|object
//     * @throws \Exception
//     *
//     * https://www.addevent.com/api/subscription-calendar#anchor-timezones
//     */
//    public function listOfTimeZones()
//    {
//        $queryString = 'https://www.addevent.com/api/v1/timezones';
//
//        $result = $this->curl($queryString);
//
//        return $result;
//    }
}
