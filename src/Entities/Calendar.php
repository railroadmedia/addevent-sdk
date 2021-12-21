<?php

namespace Railroad\AddEventSdk\Entities;

class Calendar
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
    private $customData;
    private $templateId;
    private $templateEmbedId;
    private $linkShort;
    private $linkLong;
    private $dateCreate;
    private $dateModified;

    private static $propertiesMap = [
        'id' => 'id',
        'uniquekey' => 'uniqueKey',
        'title' => 'title',
        'description' => 'description',
        'timezone' => 'timezone',
        'weekday_begin' => 'weekdayBegin',
        'calendar_color' => 'calendarColor',
        'palette_id' => 'paletteId',
        'followers_active' => 'followersActive',
        'followers_total' => 'followersTotal',
        'events_total' => 'eventsTotal',
        'custom_data' => 'customData',
        'template_id' => 'templateId',
        'template_embed_id' => 'templateEmbedId',
        'link_short' => 'linkShort',
        'link_long' => 'linkLong',
        'date_create' => 'dateCreate',
        'date_modified' => 'dateModified',
    ];

    /**
     * @throws \Exception
     */
    public function fill(\stdClass $calendar)
    {
        foreach(self::$propertiesMap as $key => $value){

            $errorMsgs = [];

            if(isset($calendar->$key)){
                $method = 'set' . ucfirst($value);
                $this->$method($calendar->$key);
            }else{
                $errorMsgs[] = $key . ' was not set on calendar passed object passed to ' . self::class . '@fill';
            }

            if(!empty($errorMsgs)){
                throw new \Exception($errorMsgs, ', also ');
            }
        }
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setUniqueKey($value)
    {
        $this->uniqueKey = $value;
    }

    public function getUniqueKey()
    {
        return $this->uniqueKey;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setDescription($value)
    {
        $this->description = $value;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setTimezone($value)
    {
        $this->timezone = $value;
    }

    public function getTimezone()
    {
        return $this->timezone;
    }

    public function setWeekdayBegin($value)
    {
        $this->weekdayBegin = $value;
    }

    public function getWeekdayBegin()
    {
        return $this->weekdayBegin;
    }

    public function setCalendarColor($value)
    {
        $this->calendarColor = $value;
    }

    public function getCalendarColor()
    {
        return $this->calendarColor;
    }

    public function setPaletteId($value)
    {
        $this->paletteId = $value;
    }

    public function getPaletteId()
    {
        return $this->paletteId;
    }

    public function setFollowersActive($value)
    {
        $this->followersActive = $value;
    }

    public function getFollowersActive()
    {
        return $this->followersActive;
    }

    public function setFollowersTotal($value)
    {
        $this->followersTotal = $value;
    }

    public function getFollowersTotal()
    {
        return $this->followersTotal;
    }

    public function setEventsTotal($value)
    {
        $this->eventsTotal = $value;
    }

    public function getEventsTotal()
    {
        return $this->eventsTotal;
    }

    public function setCustomData($value)
    {
        $this->customData = $value;
    }

    public function getCustomData()
    {
        return $this->customData;
    }

    public function setTemplateId($value)
    {
        $this->templateId = $value;
    }

    public function getTemplateId()
    {
        return $this->templateId;
    }

    public function setTemplateEmbedId($value)
    {
        $this->templateEmbedId = $value;
    }

    public function getTemplateEmbedId()
    {
        return $this->templateEmbedId;
    }

    public function setLinkShort($value)
    {
        $this->linkShort = $value;
    }

    public function getLinkShort()
    {
        return $this->linkShort;
    }

    public function setLinkLong($value)
    {
        $this->linkLong = $value;
    }

    public function getLinkLong()
    {
        return $this->linkLong;
    }

    public function setDateCreate($value)
    {
        $this->dateCreate = $value;
    }

    public function getDateCreate()
    {
        return $this->dateCreate;
    }

    public function setDateModified($value)
    {
        $this->dateModified = $value;
    }

    public function getDateModified()
    {
        return $this->dateModified;
    }
}