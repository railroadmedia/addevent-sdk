<?php

namespace Railroad\AddEventSdk\Handlers;

use Carbon\Carbon;
use Railroad\AddEventSdk\Helpers;

class EventsHandler extends Handler
{
    /**
     * @param $calendarId
     * @param null $orderBy
     * @param null $month
     * @param null $year
     * @param null $upcoming
     * @return array|bool|mixed|object
     * @throws \Exception
     */
    public function list($calendarId, $orderBy = null, $month = null, $year = null, $upcoming = null)
    {
        $results = [];
        $allRetrieved = false;

        while (!$allRetrieved) {
            $params = [
                'token' => $this->apiToken, // required
                'calendar_id' => $calendarId, // required
                'order_by' => $orderBy,
                'month' => $month,
                'year' => $year,
                'upcoming' => $upcoming
            ];
            $url = 'https://www.addevent.com/api/v1/me/calendars/events/list/?' . Helpers::arrayToQueryString($params);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            $result = $this->curl($url);
            Helpers::ensureProperty($result, 'events');
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
    public function create(
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
            'token' => $this->apiToken,      // required
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

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/create/?' . $queryString;

        $result = $this->curl($url);

        Helpers::ensureProperty($result, 'event');

        $event = $result->event;

        if ($throwExceptionOnFailure) {
            $calendarIdsMatch = $event->calendar === $calendarId;
            $descriptionsMatch = Helpers::stringsSameIfFormattingRemoved($description, $event->description);
            $titlesMatch = Helpers::stringsSameIfFormattingRemoved($title, $event->title);
            $eventWasSetAsAllDayEvent = $event->all_day_event === 'true';
            $allDayEventSettingsMatch = $eventWasSetAsAllDayEvent === $allDayEvent;
            $timesMatch = Helpers::timesMatch($event, $startDate, $endDate);

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
    public function update(
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
            'token' => $this->apiToken, // required
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

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/save/?' . $queryString;

        $result = $this->curl($url);

        Helpers::ensureProperty($result, 'event');

        $event = $result->event;

        $resultAllDayEvent = $event->all_day_event === 'true';

        $match_a = (integer) $event->id === (integer) $eventId;
        $match_b = Helpers::stringsSameIfFormattingRemoved($description, $event->description);
        $match_c = Helpers::stringsSameIfFormattingRemoved($title, $event->title);
        $match_d = $resultAllDayEvent === $allDayEvent;
        $match_e = Helpers::timesMatch($event, $startDate, $endDate);

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
    public function delete($eventId)
    {
        if (is_null($eventId)) {
            return true;
        }

        $params = [
            'token' => $this->apiToken, // required
            'event_id' => $eventId, // required
        ];

        $queryString = Helpers::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/delete/?' . $queryString;

        $result = $this->curl($url);

        Helpers::ensureProperty($result, 'event');
        Helpers::ensureProperty($result->event, 'status');
        if ($result->event->status !== 'deleted') {
            throw new \Exception(
                'Delete CURL request did not return expected \'status\' value of "deleted"' .
                ' so delete may have failed'
            );
        }

        return $result;
    }
}