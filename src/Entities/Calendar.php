<?php

namespace Railroad\AddEventSdk\Entities;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Calendar extends Entity
{
    private $id;
    private $uniqueKey;
    private $title;
    private $description;
    private $timezone;
    private $weekdayBegin;
    private $calendarColor;
    private $paletteId;
    private $followersActive;
    private $followersTotal;
    private $eventsTotal;
    private $mainCalendar;
    private $customData;
    private $templateId;
    private $templateEmbedId;
    private $linkShort;
    private $linkLong;
    private $dateCreate;
    private $dateModified;

//    private static $propertiesMap = [
//        'id' => 'id',
//        'uniquekey' => 'uniqueKey',
//        'title' => 'title',
//        'description' => 'description',
//        'timezone' => 'timezone',
//        'weekday_begin' => 'weekdayBegin',
//        'calendar_color' => 'calendarColor',
//        'palette_id' => 'paletteId',
//        'followers_active' => 'followersActive',
//        'followers_total' => 'followersTotal',
//        'events_total' => 'eventsTotal',
//        'custom_data' => 'customData',
//        'template_id' => 'templateId',
//        'template_embed_id' => 'templateEmbedId',
//        'link_short' => 'linkShort',
//        'link_long' => 'linkLong',
//        'date_create' => 'dateCreate',
//        'date_modified' => 'dateModified',
//    ];

    /**
     * @throws \Exception
     */
    public function __construct(\stdClass $stdClassObj)
    {
        parent::__construct();

        if(isset($stdClassObj->id)){
            $this->setId($stdClassObj->id); // id
        }
        if(isset($stdClassObj->uniquekey)){
            $this->setUniqueKey($stdClassObj->uniquekey); // uniqueKey
        }
        if(isset($stdClassObj->title)){
            $this->setTitle($stdClassObj->title); // title
        }
        if(isset($stdClassObj->description)){
            $this->setDescription($stdClassObj->description); // description
        }
        if(isset($stdClassObj->timezone)){
            $this->setTimezone($stdClassObj->timezone); // timezone
        }
        if(isset($stdClassObj->weekday_begin)){
            $this->setWeekdayBegin($stdClassObj->weekday_begin); // weekdayBegin
        }
        if(isset($stdClassObj->calendar_color)){
            $this->setCalendarColor($stdClassObj->calendar_color); // calendarColor
        }
        if(isset($stdClassObj->palette_id)){
            $this->setPaletteId($stdClassObj->palette_id); // paletteId
        }
        if(isset($stdClassObj->followers_active)){
            $this->setFollowersActive($stdClassObj->followers_active); // followersActive
        }
        if(isset($stdClassObj->followers_total)){
            $this->setFollowersTotal($stdClassObj->followers_total); // followersTotal
        }
        if(isset($stdClassObj->events_total)){
            $this->setEventsTotal($stdClassObj->events_total); // eventsTotal
        }
        if(isset($stdClassObj->main_calendar)){
            $this->setMainCalendar($stdClassObj->main_calendar); // eventsTotal
        }
        if(isset($stdClassObj->custom_data)){
            $this->setCustomData($stdClassObj->custom_data); // customData
        }
        if(isset($stdClassObj->template_id)){
            $this->setTemplateId($stdClassObj->template_id); // templateId
        }
        if(isset($stdClassObj->template_embed_id)){
            $this->setTemplateEmbedId($stdClassObj->template_embed_id); // templateEmbedId
        }
        if(isset($stdClassObj->link_short)){
            $this->setLinkShort($stdClassObj->link_short); // linkShort
        }
        if(isset($stdClassObj->link_long)){
            $this->setLinkLong($stdClassObj->link_long); // linkLong
        }
        if(isset($stdClassObj->date_create)){
            $this->setDateCreate($stdClassObj->date_create); // dateCreate
        }
        if(isset($stdClassObj->date_modified)){
            $this->setDateModified($stdClassObj->date_modified); // dateModified
        }
    }

    // getters and setters -----------------------------------------

    /**
     * @param string|null $value
     * @return void
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setUniqueKey($value)
    {
        $this->uniqueKey = $value;
    }

    public function getUniqueKey()
    {
        return $this->uniqueKey;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setTimezone($value)
    {
        $this->timezone = $value;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setWeekdayBegin($value)
    {
        $this->weekdayBegin = $value;
    }

    public function getWeekdayBegin()
    {
        return $this->weekdayBegin;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setCalendarColor($value)
    {
        $this->calendarColor = $value;
    }

    public function getCalendarColor()
    {
        return $this->calendarColor;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setPaletteId($value)
    {
        $this->paletteId = $value;
    }

    public function getPaletteId()
    {
        return $this->paletteId;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setFollowersActive($value)
    {
        $this->followersActive = $value;
    }

    public function getFollowersActive()
    {
        return $this->followersActive;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setFollowersTotal($value)
    {
        $this->followersTotal = $value;
    }

    public function getFollowersTotal()
    {
        return $this->followersTotal;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setEventsTotal($value)
    {
        $this->eventsTotal = $value;
    }

    public function getEventsTotal()
    {
        return $this->eventsTotal;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setMainCalendar($value)
    {
        $this->mainCalendar = filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    public function getMainCalendar()
    {
        return $this->mainCalendar;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setCustomData($value)
    {
        $this->customData = $value;
    }

    public function getCustomData()
    {
        return $this->customData;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setTemplateId($value)
    {
        $this->templateId = $value;
    }

    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setTemplateEmbedId($value)
    {
        $this->templateEmbedId = $value;
    }

    public function getTemplateEmbedId()
    {
        return $this->templateEmbedId;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setLinkShort($value)
    {
        $this->linkShort = $value;
    }

    public function getLinkShort()
    {
        return $this->linkShort;
    }

    /**
     * @param string|null $value
     * @return void
     */
    public function setLinkLong($value)
    {
        $this->linkLong = $value;
    }

    public function getLinkLong()
    {
        return $this->linkLong;
    }

    /**
     * @param int|null $value
     * @return void
     */
    public function setDateCreate($value)
    {
        $this->dateCreate = $value;
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param int|null $value
     * @return void
     */
    public function setDateModified($value)
    {
        $this->dateModified = $value;
    }

    public function getDateModified()
    {
        return $this->dateModified;
    }

    // utils -----------------------------------------

    /**
     * @return void
     * @throws \Exception
     * @var bool $ignoreDateModifiedDuringEval # needed because tests can update an entity so rapidly that this will fail
     */
    public function persist($ignoreDateModifiedDuringEval = false)
    {
        $result = $this->curl(
            'https://www.addevent.com/api/v1/me/calendars/save/?' . self::arrayToQueryString([
                'token' => $this->apiToken, // required
                'calendar_id' => $this->getId(), // required
                'title' => $this->getTitle(), // required
                'description' => $this->getDescription()
            ]));

        if($result->calendar->id !== $this->getId() ){
            throw new \Exception('value from persisted calendar not as expected. ". id" is "' . var_dump($result->calendar->id, true) . '" but should be "' . $this->getId() . '"');
        }
        if($result->calendar->uniquekey !== $this->getUniqueKey() ){
            throw new \Exception('value from persisted calendar not as expected. "uniquekey" is "' . var_dump($result->calendar->uniquekey, true) . '" but should be "' . $this->getUniqueKey() . '"');
        }
        if($result->calendar->title !== $this->getTitle() ){
            throw new \Exception('value from persisted calendar not as expected. "title" is "' . var_dump($result->calendar->title, true) . '" but should be "' . $this->getTitle() . '"');
        }
        if($result->calendar->description !== $this->getDescription() ){
            throw new \Exception('value from persisted calendar not as expected. "description" is "' . var_dump($result->calendar->description, true) . '" but should be "' . $this->getDescription() . '"');
        }
        if($result->calendar->timezone !== $this->getTimezone() ){
            throw new \Exception('value from persisted calendar not as expected. "timezone" is "' . var_dump($result->calendar->timezone, true) . '" but should be "' . $this->getTimezone() . '"');
        }
        if($result->calendar->weekday_begin !== $this->getWeekdayBegin() ){
            throw new \Exception('value from persisted calendar not as expected. "weekday_begin" is "' . var_dump($result->calendar->weekday_begin, true) . '" but should be "' . $this->getWeekdayBegin() . '"');
        }
        if($result->calendar->calendar_color !== $this->getCalendarColor() ){
            throw new \Exception('value from persisted calendar not as expected. "calendar_color" is "' . var_dump($result->calendar->calendar_color, true) . '" but should be "' . $this->getCalendarColor() . '"');
        }
        if($result->calendar->palette_id !== $this->getPaletteId() ){
            throw new \Exception('value from persisted calendar not as expected. "palette_id" is "' . var_dump($result->calendar->palette_id, true) . '" but should be "' . $this->getPaletteId() . '"');
        }
        if($result->calendar->followers_active !== $this->getFollowersActive() ){
            throw new \Exception('value from persisted calendar not as expected. "followers_active" is "' . var_dump($result->calendar->followers_active, true) . '" but should be "' . $this->getFollowersActive() . '"');
        }
        if($result->calendar->followers_total !== $this->getFollowersTotal() ){
            throw new \Exception('value from persisted calendar not as expected. "followers_total" is "' . var_dump($result->calendar->followers_total, true) . '" but should be "' . $this->getFollowersTotal() . '"');
        }
        if($result->calendar->events_total !== $this->getEventsTotal() ){
            throw new \Exception('value from persisted calendar not as expected. "events_total" is "' . var_dump($result->calendar->events_total, true) . '" but should be "' . $this->getEventsTotal() . '"');
        }
        if($result->calendar->custom_data !== $this->getCustomData() ){
            $itsFine = ($result->calendar->custom_data === '') && ($this->getCustomData() === null);
            if(!$itsFine){
                throw new \Exception('value from persisted calendar not as expected. "custom_data" is "' . var_dump($result->calendar->custom_data, true) . '" but should be "' . $this->getCustomData() . '"');
            }
        }
        if($result->calendar->template_id !== $this->getTemplateId() ){
            throw new \Exception('value from persisted calendar not as expected. "template_id" is "' . var_dump($result->calendar->template_id, true) . '" but should be "' . $this->getTemplateId() . '"');
        }
        if($result->calendar->template_embed_id !== $this->getTemplateEmbedId() ){
            throw new \Exception('value from persisted calendar not as expected. "template_embed_id" is "' . var_dump($result->calendar->template_embed_id, true) . '" but should be "' . $this->getTemplateEmbedId() . '"');
        }
        if($result->calendar->link_short !== $this->getLinkShort() ){
            throw new \Exception('value from persisted calendar not as expected. "link_short" is "' . var_dump($result->calendar->link_short, true) . '" but should be "' . $this->getLinkShort() . '"');
        }
        if($result->calendar->link_long !== $this->getLinkLong() ){
            throw new \Exception('value from persisted calendar not as expected. "link_long" is "' . var_dump($result->calendar->link_long, true) . '" but should be "' . $this->getLinkLong() . '"');
        }
        if($result->calendar->date_create !== $this->getDateCreate() ){
            throw new \Exception('value from persisted calendar not as expected. "date_create" is "' . var_dump($result->calendar->date_create, true) . '" but should be "' . $this->getDateCreate() . '"');
        }

        if(!$ignoreDateModifiedDuringEval){
            if($result->calendar->date_modified === $this->getDateModified() ){
                throw new \Exception('value from persisted calendar not as expected. "date_modified" is the same value ("' . $this->getDateModified() . '") before and after persist');
            }
        }
    }

    public function delete()
    {
        $params = [
            'token' => $this->apiToken, // required
            'calendar_id' => $this->getId()
        ];

        $result = $this->curl('https://www.addevent.com/api/v1/me/calendars/delete/?' . self::arrayToQueryString($params));

        $deleted = $result->calendar->status === 'deleted';

        if(!$deleted){
            throw new \Exception('Reponse not as expected. curl $result did not meet $result->calendar->status === \'deleted\' check. Rather value of $result is: "' . var_dump($deleted, true) . '"');
        }

        $this->setId(null);
        $this->setUniqueKey(null);
        $this->setTitle(null);
        $this->setDescription(null);
        $this->setTimezone(null);
        $this->setWeekdayBegin(null);
        $this->setCalendarColor(null);
        $this->setPaletteId(null);
        $this->setFollowersActive(null);
        $this->setFollowersTotal(null);
        $this->setEventsTotal(null);
        $this->setCustomData(null);
        $this->setTemplateId(null);
        $this->setTemplateEmbedId(null);
        $this->setLinkShort(null);
        $this->setLinkLong(null);
        $this->setDateCreate(null);
        $this->setDateModified(null);
    }

    /**
     * @return Collection|Event[]
     * @throws \Exception
     *
     * Note: there are more query params available in AddEvent's API. Specifically "order_by", "month", "year" and "upcoming"
     */
    public function events()
    {
        $results = [];
        $allRetrieved = false;

        while (!$allRetrieved) {
            $url = 'https://www.addevent.com/api/v1/me/calendars/events/list/?' . self::arrayToQueryString([
                'token' => $this->apiToken, 'calendar_id' => $this->getId()
            ]);

            if (!empty($pagingNext)) {
                $url = $pagingNext;
            }

            $result = $this->curl($url);
            self::ensureProperty($result, 'events');
            if (gettype($result->events) !== 'array') {
                throw new \Exception('listEventsInCalendar CURL response data "events" is not an array as expected.');
            }

            $pagingNext = $result->paging->next;
            if (empty($pagingNext)) {
                $allRetrieved = true;
            }
            $results = array_merge($results, $result->events);
        }

        $events = new Collection();

        foreach($results as $eventRaw){
            $event = new Event($eventRaw);
            $events->add($event);
        }

        return $events;
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
        string $title,
        string $timezone,
        Carbon $startDate,
        Carbon $endDate = null,
        $description = null,
        $organizer = null,
        $organizerEmail = null,
        $location = null,
        $reminder = null,
        bool $allDayEvent = false,
        bool $throwExceptionOnFailure = true // todo: remove this?
    )
    {
        $startDateFormatted = $startDate->toDateTimeString();
        if ($endDate) {
            $endDate = $endDate->toDateTimeString();
        }

        $params = [
            'token' => $this->apiToken,      // required
            'calendar_id' => $this->getId(),   // required
            'title' => $title,              // required
            'timezone' => $timezone,        // required
            'start_date' => $startDateFormatted,     // required
            'description' => $description,
            'end_date' => $endDate,
            'organizer' => $organizer,
            'organizer_email' => $organizerEmail,
            'location' => $location,
            'reminder' => $reminder,
            'all_day_event' => $allDayEvent,
        ];

        $queryString = self::arrayToQueryString($params);

        $url = 'https://www.addevent.com/api/v1/me/calendars/events/create/?' . $queryString;

        $result = $this->curl($url);

        self::ensureProperty($result, 'event');

        $event = $result->event;

        if ($throwExceptionOnFailure) {
            $matchingCalendarIds = $event->calendar === $this->getId();
            $matchingDescriptions = self::stringsSameIfFormattingRemoved($description, $event->description);
            $matchingTitles = self::stringsSameIfFormattingRemoved($title, $event->title);
            $eventWasSetAsAllDayEvent = $event->all_day_event === 'true';
            $matchingAllDayEventSettings = $eventWasSetAsAllDayEvent === $allDayEvent;

            $startDateObj = Carbon::parse($startDateFormatted, $timezone);

            $matchingStartTimes = self::timesMatch($event, $startDateObj, $endDate);

            $enoughInfoCorrectToConsiderSuccess =
                $matchingCalendarIds && $matchingDescriptions && $matchingTitles && $matchingAllDayEventSettings && $matchingStartTimes;

            if (!$enoughInfoCorrectToConsiderSuccess && $throwExceptionOnFailure) {
                throw new \Exception(
                    'Event created, but discrepancy between expected and actual values. ' .
                    'expected: ' . var_export(
                        [$event->calendar, $title, $description, $event->all_day_event],
                        true
                    ) .
                    'actual: ' . var_export([$this->getId(), $event->title, $event->description, $allDayEvent], true)
                );
            }
        }

        return new Event($event);
    }
}