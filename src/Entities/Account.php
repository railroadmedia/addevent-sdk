<?php

namespace Railroad\AddEventSdk\Entities;

use Illuminate\Support\Collection;

class Account extends Entity
{
    private $calendars;

    /**
     * @return bool
     */
    public function fillCalendars()
    {
        $calendarsRaw = [];
        $calendars = new Collection();
        $allRetrieved = false;
        $finishedWithoutError = true;

        while (!$allRetrieved) {
            $params = ['token' => $this->apiToken];

            $url = 'https://www.addevent.com/api/v1/me/calendars/list/?' . self::arrayToQueryString($params);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            try{
                $result = $this->curl($url);
                self::ensureProperty($result, 'calendars');

                $pagingNext = $result->paging->next;
                if (empty($pagingNext)) {
                    $allRetrieved = true;
                }
                $calendarsRaw = array_merge($calendarsRaw, $result->calendars);
            }catch(\Exception $e){
                error_log($e);
                $finishedWithoutError = false;
            }
        }

        foreach($calendarsRaw as $calendarRaw){
            $calendars->push(new Calendar($calendarRaw));
        }

        $this->calendars = $calendars;

        return $finishedWithoutError;
    }


    /**
     * @returns Collection|Calendar[]
     * @throws \Exception
     */
    public function getCalendars()
    {
        if(empty($this->calendars)){
            try{
                $success = $this->fillCalendars();
                if(!$success){
                    return false;
                }
            }catch(\Exception $e){
                error_log($e);
                return false;
            }
        }
        return $this->calendars;
    }

    public function getCalendarById($calendarId)
    {
        $calendars = $this->getCalendars();

        /** @var Calendar $calendarCandidate */
        foreach($calendars as $calendarCandidate){
            if($calendarCandidate->getId() === $calendarId){
                return $calendarCandidate;
            }
        }

        return false;
    }

    public function getCalendarByName($name)
    {
        $calendars = $this->getCalendars();

        /** @var Calendar $calendarCandidate */
        foreach($calendars as $calendarCandidate){
            if($calendarCandidate->getTitle() === $name){
                return $calendarCandidate;
            }
        }

        return false;
    }

    /**
     * @param string $title
     * @param string|null $description
     * @return Calendar
     * @throws \Exception
     */
    public function createCalendar(string $title, string $description = null)
    {
        return new Calendar(
            $this->curl(
                'https://www.addevent.com/api/v1/me/calendars/create/?' .
                self::arrayToQueryString([
                    'token' => $this->apiToken,
                    'title' => $title,
                    'description' => $description
                ])
            )->calendar
        );
    }

    public function getTimezones()
    {
        $result = $this->curl('https://www.addevent.com/api/v1/timezones');

        $timezonesSimple = [];

        foreach($result->data as $timezone){
            $timezonesSimple[] = $timezone->label;
        }

        return $timezonesSimple;
    }
}