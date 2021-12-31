<?php

namespace Railroad\AddEventSdk\Entities;

use App\ValueObjects\AddEventCalendarEventVO;
use Carbon\Carbon;
use DateTimeZone;

class Event extends Entity
{
    private $id;
    private $calendar;
    private $unique;
    private $title;
    private $description;
    private $location;
    private $organizer;
    private $organizerEmail;
    private $dateStart;
    private $dateStartTime;
    private $dateStartAmPm;
    private $dateEnd;
    private $dateEndTime;
    private $dateEndAmPm;
    private $allDayEvent;
    private $dateFormat;
    private $timezone;
    private $reminder;
    private $rRule;
    private $templateId;
    private $color;
    private $customData;
    private $updatedTimes;
    private $linkShort;
    private $linkLong;
    private $dateCreate;
    private $dateModified;

    public static $customDataSyncIdKey = 'sync_id';

    public function __construct($stdClassObj, $calendarId)
    {
        parent::__construct();

        // example: '10954490',
        if(isset($stdClassObj->id)){
            $this->setId($stdClassObj->id);
        }

        // example: '1640324918396800',
        $this->setcalendar($calendarId);

        // example: 'rl10954490',
        if(isset($stdClassObj->unique)){
            $this->setUnique($stdClassObj->unique);
        }

        // example: 'Repudiandae quia quos quo deserunt voluptas',
        if(isset($stdClassObj->title)){
            $this->setTitle($stdClassObj->title);
        }

        // example: '',
        if(isset($stdClassObj->description)){
            $this->setDescription($stdClassObj->description);
        }

        // example: '',
        if(isset($stdClassObj->location)){
            $this->setlocation($stdClassObj->location);
        }

        // example: '',
        if(isset($stdClassObj->organizer)){
            $this->setOrganizer($stdClassObj->organizer);
        }

        // example: '',
        if(isset($stdClassObj->organizer_email)){
            $this->setOrganizerEmail($stdClassObj->organizer_email);
        }

        // example: '01/09/2022',
        if(isset($stdClassObj->date_start)){
            $this->setDateStart($stdClassObj->date_start);
        }

        // example: '14:45:38',
        if(isset($stdClassObj->date_start_time)){
            $this->setDateStartTime($stdClassObj->date_start_time);
        }

        // example: 'PM',
        if(isset($stdClassObj->date_start_ampm)){
            $this->setDateStartAmPm($stdClassObj->date_start_ampm);
        }

        // example: '01/09/2022',
        if(isset($stdClassObj->date_end)){
            $this->setDateEnd($stdClassObj->date_end);
        }

        // example: '15:45:38',
        if(isset($stdClassObj->date_end_time)){
            $this->setDateEndTime($stdClassObj->date_end_time);
        }

        // example: 'PM',
        if(isset($stdClassObj->date_end_ampm)){
            $this->setDateEndAmPm($stdClassObj->date_end_ampm);
        }

        // example: 'false',
        if(isset($stdClassObj->all_day_event)){
            $this->setAllDayEvent($stdClassObj->all_day_event);
        }

        // example: 'MM/DD/YYYY',
        if(isset($stdClassObj->date_format)){
            $this->setDateFormat($stdClassObj->date_format);
        }

        // example: 'Asia/Nicosia',
        if(isset($stdClassObj->timezone)){
            $this->setTimezone($stdClassObj->timezone);
        }

        // example: '',
        if(isset($stdClassObj->reminder)){
            $this->setReminder($stdClassObj->reminder);
        }

        // example: '',
        if(isset($stdClassObj->rrule)){
            $this->setRRule($stdClassObj->rrule);
        }

        // example: '',
        if(isset($stdClassObj->template_id)){
            $this->setTemplateId($stdClassObj->template_id);
        }

        // example: '0',
        if(isset($stdClassObj->color)){
            $this->setColor($stdClassObj->color);
        }

        // example: '',
        if(isset($stdClassObj->custom_data)){
            $this->setCustomData(json_decode($stdClassObj->custom_data));
        }

        // example: '0',
        if(isset($stdClassObj->updated_times)){
            $this->setUpdatedTimes($stdClassObj->updated_times);
        }

        // example: 'https://evt.to/amsiuusmw',
        if(isset($stdClassObj->link_short)){
            $this->setLinkShort($stdClassObj->link_short);
        }

        // example: 'https://www.addevent.com/event/rl10954490',
        if(isset($stdClassObj->link_long)){
            $this->setLinkLong($stdClassObj->link_long);
        }

        // example: 1640324919,
        if(isset($stdClassObj->date_create)){
            $this->setDateCreate($stdClassObj->date_create);
        }

        // example: 1640324919,
        if(isset($stdClassObj->date_modified)){
            $this->setDateModified($stdClassObj->date_modified);
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCalendar()
    {
        return $this->calendar;
    }

    /**
     * @param string $calendar
     */
    public function setCalendar($calendar): void
    {
        $this->calendar = $calendar;
    }

    /**
     * @return string
     */
    public function getUnique()
    {
        return $this->unique;
    }

    /**
     * @param string $unique
     */
    public function setUnique($unique): void
    {
        $this->unique = $unique;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location): void
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getOrganizer()
    {
        return $this->organizer;
    }

    /**
     * @param string $organizer
     */
    public function setOrganizer($organizer): void
    {
        $this->organizer = $organizer;
    }

    /**
     * @return string
     */
    public function getOrganizerEmail()
    {
        return $this->organizerEmail;
    }

    /**
     * @param string $organizerEmail
     */
    public function setOrganizerEmail($organizerEmail): void
    {
        $this->organizerEmail = $organizerEmail;
    }

    /**
     * @return string
     */
    public function getDateStart()
    {
        return $this->dateStart;
    }

    /**
     * @param string $dateStart
     */
    private function setDateStart($dateStart): void
    {
        $this->dateStart = $dateStart;
    }

    /**
     * @return string
     */
    public function getDateStartTime()
    {
        return $this->dateStartTime;
    }

    /**
     * @param string $dateStartTime
     */
    private function setDateStartTime($dateStartTime): void
    {
        $this->dateStartTime = $dateStartTime;
    }

    /**
     * @return string
     */
    public function getDateStartAmPm()
    {
        return $this->dateStartAmPm;
    }

    /**
     * @param string $dateStartAmPm
     */
    private function setDateStartAmPm($dateStartAmPm): void
    {
        $this->dateStartAmPm = $dateStartAmPm;
    }

    /**
     * @return string
     */
    public function getDateEnd()
    {
        return $this->dateEnd;
    }

    /**
     * @param string $dateEnd
     */
    private function setDateEnd($dateEnd): void
    {
        $this->dateEnd = $dateEnd;
    }

    /**
     * @return string
     */
    public function getDateEndTime()
    {
        return $this->dateEndTime;
    }

    /**
     * @param string $dateEndTime
     */
    private function setDateEndTime($dateEndTime): void
    {
        $this->dateEndTime = $dateEndTime;
    }

    /**
     * @return string
     */
    public function getDateEndAmPm()
    {
        return $this->dateEndAmPm;
    }

    /**
     * @param string $dateEndAmPm
     */
    private function setDateEndAmPm($dateEndAmPm): void
    {
        $this->dateEndAmPm = $dateEndAmPm;
    }

    /**
     * @return bool
     */
    public function getAllDayEvent()
    {
        return $this->allDayEvent;
    }

    /**
     * @param string $allDayEvent
     */
    public function setAllDayEvent($allDayEvent): void
    {
        $this->allDayEvent = filter_var($allDayEvent, FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @return string
     */
    public function getDateFormat()
    {
        return $this->dateFormat;
    }

    /**
     * @param string $dateFormat
     */
    public function setDateFormat($dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    /**
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param DateTimeZone|string $timezone
     * @return string
     */
    public function setTimezone($timezone): void
    {
        if(is_object($timezone)){

            $class = get_class($timezone);

            if($class === DateTimeZone::class){
                /** @var DateTimeZone $timezone */
                $timezone = $timezone->getName();
            }
        }

        /** @var string timezone */
        $this->timezone = $timezone;
    }

    /**
     * @return string
     */
    public function getReminder()
    {
        return $this->reminder;
    }

    /**
     * @param string $reminder
     */
    public function setReminder($reminder): void
    {
        $this->reminder = $reminder;
    }

    /**
     * @return string
     */
    public function getRRule()
    {
        return $this->rRule;
    }

    /**
     * @param string $rRule
     */
    public function setRRule($rRule): void
    {
        $this->rRule = $rRule;
    }

    /**
     * @return string
     */
    public function getTemplateId()
    {
        return $this->templateId;
    }

    /**
     * @param string $templateId
     */
    public function setTemplateId($templateId): void
    {
        $this->templateId = $templateId;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return array
     */
    public function getCustomData() : array
    {
        return json_decode(json_encode($this->customData), true) ?? [];
    }

    /**
     * @param array $customData
     */
    public function setCustomData($customData): void
    {
        $this->customData = $customData;
    }

    /**
     * @return string
     */
    public function getUpdatedTimes()
    {
        return $this->updatedTimes;
    }

    /**
     * @param string $updatedTimes
     */
    public function setUpdatedTimes($updatedTimes): void
    {
        $this->updatedTimes = $updatedTimes;
    }

    /**
     * @return string
     */
    public function getLinkShort()
    {
        return $this->linkShort;
    }

    /**
     * @param string $linkShort
     */
    public function setLinkShort($linkShort): void
    {
        $this->linkShort = $linkShort;
    }

    /**
     * @return string
     */
    public function getLinkLong()
    {
        return $this->linkLong;
    }

    /**
     * @param string $linkLong
     */
    public function setLinkLong($linkLong): void
    {
        $this->linkLong = $linkLong;
    }

    /**
     * @return string
     */
    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    /**
     * @param mixed $dateCreate
     */
    public function setDateCreate($dateCreate): void
    {
        $this->dateCreate = $dateCreate;
    }

    /**
     * @return int
     */
    public function getDateModified()
    {
        return $this->dateModified;
    }

    /**
     * @param int $dateModified
     */
    public function setDateModified($dateModified): void
    {
        $this->dateModified = $dateModified;
    }

    // --------------------------------------------------------------

    /**
     * @return Carbon|false
     */
    public function getStart()
    {
        $actualDateStartConcatenated = $this->getDateStart() . ' ' . $this->getDateStartTime();

        return Carbon::createFromFormat('m/d/Y H:i:s', $actualDateStartConcatenated, $this->getTimezone());
    }

    /**
     * @return Carbon|false
     */
    public function getEnd()
    {
        $concat = $this->getDateEnd() . ' ' . $this->getDateEndTime() . ' ' . $this->getDateEndAmPm();
        return Carbon::createFromFormat('m/d/Y H:i:s A', $concat, $this->getTimezone());
    }

    public function setStartAndEnd(Carbon $start, ?Carbon $end)
    {
        if($end === null){
            $end = $start->copy()->addHour();
        }

        if(!empty($this->getStart()) && !empty($this->getEnd())){
            $newStartIsAfterCurrentEnd = $start->gt($this->getEnd());
            if($newStartIsAfterCurrentEnd){
                $previousLength = $this->getStart()->diffInSeconds($this->getEnd());
                $end->addSeconds($previousLength);
            }
        }

        $this->setDateStart($start->format('m/d/Y'));
        $this->setDateStartTime($start->format('H:i:s'));
        $this->setDateStartAmPm($start->format('A'));
        $this->setTimezone($start->getTimezone());

        if($end->lt($start)){
            throw new \Exception('Cannot set new end that is time before start');
        }

        $this->setDateEnd($end->format('m/d/Y'));
        $this->setDateEndTime($end->format('H:i:s'));
        $this->setDateEndAmPm($end->format('A'));
        $this->setTimezone($end->getTimezone());
    }

    public function persist()
    {
        $getStartProduct = $this->getStart();
        $setThisStartDate = $getStartProduct->toDateTimeString();

        $params = [
            'token' => $this->apiToken, // required
            'event_id' => $this->getId(), // required
            'title' => $this->getTitle(), // required
            'description' => $this->getDescription(),
            'location' => $this->getLocation(),
            'organizer' => $this->getOrganizer(),
            'organizer_email' => $this->getOrganizerEmail(),
            'timezone' => $this->getTimezone(), // required
            'reminder' => $this->getReminder(),
            'start_date' => $setThisStartDate, // required
            'end_date' => $this->getEnd()->toDateTimeString(),
            'all_day_event' => $this->getAllDayEvent(),
        ];

        $result = $this->curl(
            'https://www.addevent.com/api/v1/me/calendars/events/save/?' . self::arrayToQueryString($params)
        );

        $copy = new Event($result->event, $this->getCalendar());

        if($this->getId() !== $copy->getId()){
            throw new \Exception('value from persisted event not as expected.');
        }
    }

    public function delete()
    {
        $url = 'https://www.addevent.com/api/v1/me/calendars/events/delete/?' . self::arrayToQueryString([
            'token' => $this->apiToken, 'event_id' => $this->getId()
        ]);

        $result = $this->curl($url);

        self::ensureProperty($result, 'event');
        self::ensureProperty($result->event, 'status');
        if ($result->event->status !== 'deleted') {
            throw new \Exception(
                'Delete CURL request did not return expected \'status\' value of "deleted"' .
                ' so delete may have failed'
            );
        }

        $this->setId(null);
        $this->setCalendar(null);
        $this->setUnique(null);
        $this->setTitle(null);
        $this->setDescription(null);
        $this->setLocation(null);
        $this->setOrganizer(null);
        $this->setOrganizerEmail(null);
        $this->setDateStart(null);
        $this->setDateStartTime(null);
        $this->setDateStartAmPm(null);
        $this->setDateEnd(null);
        $this->setDateEndTime(null);
        $this->setDateEndAmPm(null);
        $this->setAllDayEvent(null);
        $this->setDateFormat(null);
        $this->setTimezone(null);
        $this->setReminder(null);
        $this->setRRule(null);
        $this->setTemplateId(null);
        $this->setColor(null);
        $this->setCustomData(null);
        $this->setUpdatedTimes(null);
        $this->setLinkShort(null);
        $this->setLinkLong(null);
        $this->setDateCreate(null);
        $this->setDateModified(null);
    }
}