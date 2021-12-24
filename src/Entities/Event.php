<?php

namespace Railroad\AddEventSdk\Entities;

class Event
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

    public function __construct($stdClassObj)
    {
        // example: '10954490',
        if(isset($stdClassObj->id)){
            $this->setId($stdClassObj->id);
        }

        // example: '1640324918396800',
        if(isset($stdClassObj->calendar)){
            $this->setcalendar($stdClassObj->calendar);
        }

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
            $this->setdateStartTime($stdClassObj->date_start_time);
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
            $this->setCustomData($stdClassObj->custom_data);
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
    public function setId(string $id): void
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
    public function setCalendar(string $calendar): void
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
    public function setUnique(string $unique): void
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
    public function setTitle(string $title): void
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
    public function setDescription(string $description): void
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
    public function setLocation(string $location): void
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
    public function setOrganizer(string $organizer): void
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
    public function setOrganizerEmail(string $organizerEmail): void
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
    public function setDateStart(string $dateStart): void
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
    public function setDateStartTime(string $dateStartTime): void
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
    public function setDateStartAmPm(string $dateStartAmPm): void
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
    public function setDateEnd(string $dateEnd): void
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
    public function setDateEndTime(string $dateEndTime): void
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
    public function setDateEndAmPm(string $dateEndAmPm): void
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
    public function setAllDayEvent(string $allDayEvent): void
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
    public function setDateFormat(string $dateFormat): void
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
     * @param string $timezone
     */
    public function setTimezone(string $timezone): void
    {
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
    public function setReminder(string $reminder): void
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
    public function setRRule(string $rRule): void
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
    public function setTemplateId(string $templateId): void
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
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getCustomData()
    {
        return $this->customData;
    }

    /**
     * @param string $customData
     */
    public function setCustomData(string $customData): void
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
    public function setUpdatedTimes(string $updatedTimes): void
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
    public function setLinkShort(string $linkShort): void
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
    public function setLinkLong(string $linkLong): void
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
    public function setDateCreate(int $dateCreate): void
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
    public function setDateModified(int $dateModified): void
    {
        $this->dateModified = $dateModified;
    }


}