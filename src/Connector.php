<?php

namespace Railroad\AddEventSdk;

use Carbon\Carbon;

/**
 * Class Connector
 * @package Railroad\AddEventSdk
 *
 * See AddEvent docs:
 * addevent.com/api/subscription-calendar
 */
class Connector
{
    /**
     * @var Helper
     */
    private $helper;

    public function __construct(Helper $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getCalendars()
    {
        $calendars = [];
        $allRetrieved = false;

        while (!$allRetrieved) {
            $params = ['token' => config('add-event.api-token')];

            $url = 'https://www.addevent.com/api/v1/me/calendars/list/?' . $this->helper->arrayToQueryString($params);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            $result = $this->helper->curl($url);
            $this->helper->ensureProperty($result, 'calendars');

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
    public function createCalendar($title, $description = null)
    {
        $params = [
            'token' => config('add-event.api-token'), // required
            'title' => $title, // required
            'description' => $description
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/create/?' . $queryString;

        $result = $this->helper->curl($url);

        $this->helper->ensureProperty($result, 'calendar');

        return $result->calendar;
    }

    /**
     * @param $calendarId
     * @param $title
     * @param $description
     * @return mixed
     * @throws \Exception
     */
    public function saveCalendar($calendarId, $title, $description)
    {
        $params = [
            'token' => config('add-event.api-token'), // required
            'calendar-id' => $calendarId, // required
            'title' => $title, // required
            'description' => $description
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/save/?' . $queryString;

        $result = $this->helper->curl($url);

        $this->helper->ensureProperty($result, 'calendar');

        return $result->calendar;
    }

    /**
     * @param $calendarId
     * @param bool $ensureDeletedWithSecondRequest
     * @return bool
     * @throws \Exception
     */
    public function deleteCalendar($calendarId, $ensureDeletedWithSecondRequest = true)
    {
        $params = [
            'token' => config('add-event.api-token'), // required
            'calendar_id' => $calendarId
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/delete/?' . $queryString;

        $result = $this->helper->curl($url);

        if (!property_exists($result, 'calendar')) {
            throw new \Exception('deleteCalendar CURL response data missing "calendar" property');
        }

        // $idOfDeleted = $result->calendar->id;
        $deleted = $result->calendar->status === 'deleted';

        if ($ensureDeletedWithSecondRequest) {
            foreach ($this->getCalendars() as $calendar) {
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

    /**
     * @param $calendarId
     * @param null $orderBy
     * @param null $month
     * @param null $year
     * @param null $upcoming
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function listEventsInCalendar($calendarId, $orderBy = null, $month = null, $year = null, $upcoming = null)
    {
        $results = [];
        $allRetrieved = false;

        while (!$allRetrieved) {
            $params = [
                'token' => config('add-event.api-token'), // required
                'calendar_id' => $calendarId, // required
                'order_by' => $orderBy,
                'month' => $month,
                'year' => $year,
                'upcoming' => $upcoming
            ];
            $url = 'https://www.addevent.com/api/v1/me/calendars/events/list/?' . $this->helper->arrayToQueryString($params);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            $result = $this->helper->curl($url);
            $this->helper->ensureProperty($result, 'events');
            if (gettype($result->events) !== 'array') {
                throw new \Exception('listEventsInCalendar CURL response data "events" is not an array as expected.');
            }

            $pagingNext = $result->paging->next;
            if (empty($pagingNext)) {
                $allRetrieved = true;
            }
            $results = array_merge($results, $result->events);
        }

        return $results;
    }

    /**
     * @param $calendarId
     * @param $title
     * @param Carbon $startDate
     * @param string $timezone
     * @param null $description
     * @param bool $allDayEvent
     * @param null $organizer
     * @param null $organizerEmail
     * @param null $location
     * @param null $reminder
     * @param Carbon $endDate
     * @param bool $throwExceptionOnFailure
     * @return mixed
     * @throws \Exception
     */
    public function createEvent(
        $calendarId,
        $title,
        $timezone,
        Carbon $startDate,
        Carbon $endDate = null,
        $description = null,
        $organizer = null,
        $organizerEmail = null,
        $location = null,
        $reminder = null,
        $allDayEvent = false,
        $throwExceptionOnFailure = true // todo: remove this?
    )
    {
        $startDate = $startDate->toDateTimeString();
        if ($endDate) {
            $endDate = $endDate->toDateTimeString();
        }

        $params = [
            'token' => config('add-event.api-token'),      // required
            'calendar_id' => $calendarId,   // required
            'title' => $title,              // required
            'timezone' => $timezone,        // required
            'start_date' => $startDate,     // required
            'description' => $description,
            'end_date' => $endDate,
            'organizer' => $organizer,
            'organizer_email' => $organizerEmail,
            'location' => $location,
            'reminder' => $reminder,
            'all_day_event' => $allDayEvent,
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/create/?' . $queryString;

        $result = $this->helper->curl($url);

        $this->helper->ensureProperty($result, 'event');

        $event = $result->event;

        if ($throwExceptionOnFailure) {
            $calendarIdsMatch = $event->calendar === $calendarId;
            $descriptionsMatch = $this->helper->stringsSameIfFormattingRemoved($description, $event->description);
            $titlesMatch = $this->helper->stringsSameIfFormattingRemoved($title, $event->title);
            $eventWasSetAsAllDayEvent = $event->all_day_event === 'true';
            $allDayEventSettingsMatch = $eventWasSetAsAllDayEvent === $allDayEvent;
            $timesMatch = $this->helper->timesMatch($event, $startDate, $endDate);

            $enoughInfoCorrectToConsiderSuccess =
                $calendarIdsMatch && $descriptionsMatch && $titlesMatch && $allDayEventSettingsMatch && $timesMatch;

            if (!$enoughInfoCorrectToConsiderSuccess && $throwExceptionOnFailure) {
                throw new \Exception(
                    'Event created, but discrepancy between expected and actual values. ' .
                    'expected: ' . var_export(
                        [$event->calendar, $title, $description, $event->all_day_event],
                        true
                    ) .
                    'actual: ' . var_export([$calendarId, $event->title, $event->description, $allDayEvent], true)
                );
            }
        }

        return $event;
    }

    /**
     * @param $eventId
     * @param $title
     * @param $timezone
     * @param Carbon $startDate
     * @param Carbon|null $endDate
     * @param null $description
     * @param bool $allDayEvent
     * @param null $organizer
     * @param null $organizerEmail
     * @param null $location
     * @param null $reminder
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function editEvent(
        $eventId,
        $title,
        $timezone,
        Carbon $startDate,
        Carbon $endDate = null,
        $description = null,
        $organizer = null,
        $organizerEmail = null,
        $allDayEvent = false,
        $location = null,
        $reminder = null
    ) {
        $startDate = $startDate->toDateTimeString();
        if ($endDate) {
            $endDate = $endDate->toDateTimeString();
        }

        $params = [
            'token' => config('add-event.api-token'), // required
            'event_id' => $eventId, // required
            'title' => $title, // required
            'description' => $description,
            'location' => $location,
            'organizer' => $organizer,
            'organizer_email' => $organizerEmail,
            'timezone' => $timezone, // required
            'reminder' => $reminder,
            'start_date' => $startDate, // required
            'end_date' => $endDate,
            'all_day_event' => $allDayEvent,
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/save/?' . $queryString;

        $result = $this->helper->curl($url);

        $this->helper->ensureProperty($result, 'event');

        $event = $result->event;

        $resultAllDayEvent = $event->all_day_event === 'true';

        $match_a = (integer) $event->id === (integer) $eventId;
        $match_b = $this->helper->stringsSameIfFormattingRemoved($description, $event->description);
        $match_c = $this->helper->stringsSameIfFormattingRemoved($title, $event->title);
        $match_d = $resultAllDayEvent === $allDayEvent;
        $match_e = $this->helper->timesMatch($event, $startDate, $endDate);

        $enoughInfoCorrectToConsiderSuccess = $match_a && $match_b && $match_c && $match_d && $match_e;

        if (!$enoughInfoCorrectToConsiderSuccess) {
            throw new \Exception(
                'Event created, but discrepancy between expected and actual values. ' .
                'expected: ' . var_export(
                    [$eventId, $title, $description, $allDayEvent],
                    true
                ) .
                'actual: ' . var_export([$event->id, $event->title, $event->description, $resultAllDayEvent], true)
            );
        }

        return $result;
    }

    /**
     * @param $eventId
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function deleteEvent($eventId)
    {
        if (is_null($eventId)) {
            return true;
        }

        $params = [
            'token' => config('add-event.api-token'), // required
            'event_id' => $eventId, // required
        ];

        $queryString = $this->helper->arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/delete/?' . $queryString;

        $result = $this->helper->curl($url);

        $this->helper->ensureProperty($result, 'event');
        $this->helper->ensureProperty($result->event, 'status');
        if ($result->event->status !== 'deleted') {
            throw new \Exception(
                'Delete CURL request did not return expected \'status\' value of "deleted"' .
                ' so delete may have failed'
            );
        }

        return $result;
    }

    /**
     * @return array|bool|mixed|object
     * @throws \Exception
     *
     * https://www.addevent.com/api/subscription-calendar#anchor-timezones
     */
    public function listOfTimeZones()
    {
        $queryString = 'https://www.addevent.com/api/v1/timezones';

        $result = $this->helper->curl($queryString);

        return $result;
    }
}
