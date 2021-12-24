<?php

use Carbon\Carbon;
use Railroad\AddEventSdk\Entities\Event;
use Railroad\AddEventSdk\Helpers;
use Railroad\AddEventSdk\Tests\TestCase;

// todo: OOP the shit outta this
// todo: add test cases where more params are specified when creating events?

class EventsHandlerTest extends TestCase
{
    public function test_create()
    {
        $calendar = $this->createTestCalendar();

        $calendarId = $calendar->id;

        $eventTitleToSet = trim($this->faker->sentence, '.');
        $timezoneToSet = $this->faker->timezone;
        $startDateToSet = Carbon::now($timezoneToSet)->addDays(rand(2,20))->addMinutes(rand(0,60*24));

        $eventCreated = $this->eventsHandler->create(
            $calendarId,
            $eventTitleToSet,
            $timezoneToSet,
            $startDateToSet
        );

        try{
            $eventObj = new Event($eventCreated);
        }catch(\Exception $e){
            $this->fail('failed with exception with message: ' . $e->getMessage());
        }
        $this->assertNotEmpty($eventObj->getId());
        $this->assertSame($eventTitleToSet, $eventObj->getTitle());
        $this->assertSame($timezoneToSet, $eventObj->getTimezone());
    }

    public function test_read()
    {
        $calendar = $this->createTestCalendar();

        $calendarId = $calendar->id;

        // assert no events in calendar

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        if(!empty($eventsInCalendar)){
            $this->fail('Events in calendar when there should not be, test aborted because set up is not correct');
        }

        // create event

        $eventTitleToSet = trim($this->faker->sentence, '.');
        $timezoneToSet = $this->faker->timezone;
        $startDateToSet = Carbon::now($timezoneToSet)->addDays(rand(2,20))->addMinutes(rand(0,60*24));

        $eventCreated = $this->eventsHandler->create(
            $calendarId,
            $eventTitleToSet,
            $timezoneToSet,
            $startDateToSet
        );

        // fetch events

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        $this->assertNotEmpty($eventsInCalendar);
        $this->assertEquals(1, count($eventsInCalendar));

        $eventToVerify = null;

        foreach($eventsInCalendar as $eventInCalendar){
            if($eventInCalendar->id === $eventCreated->id){
                $eventToVerify = $eventInCalendar;
            }
        }

        $this->assertNotEmpty($eventToVerify);

        // assert event matches expectations

        $this->assertSame($eventTitleToSet, $eventToVerify->title);
        $this->assertSame($timezoneToSet, $eventToVerify->timezone);
        $this->assertTrue(Helpers::timesMatch($eventToVerify, $startDateToSet));
    }

    public function test_update()
    {
        $calendar = $this->createTestCalendar();

        $calendarId = $calendar->id;

        // assert no events in calendar

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        if(!empty($eventsInCalendar)){
            $this->fail('Events in calendar when there should not be, test aborted because set up is not correct');
        }

        // create event

        $eventTitleToSet = trim($this->faker->sentence, '.');
        $timezoneToSet = $this->faker->timezone;
        $startDateToSet = Carbon::now($timezoneToSet)->addDays(rand(2,20))->addMinutes(rand(0,60*24));

        $eventCreated = $this->eventsHandler->create(
            $calendarId,
            $eventTitleToSet,
            $timezoneToSet,
            $startDateToSet
        );

        // edit event

        $eventTitleToUpdate = trim($this->faker->sentence, '.');
        $startDateToUpdate = Carbon::parse($startDateToSet, $timezoneToSet)->addDays(rand(1,10))->addHours(rand(1,23));

        $eventUpdated = $this->eventsHandler->update(
            $eventCreated->id,
            $eventTitleToUpdate,
            $eventCreated->timezone,
            $startDateToUpdate,
        );

        // fetch events

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        $this->assertNotEmpty($eventsInCalendar);
        $this->assertEquals(1, count($eventsInCalendar));

        $eventToVerify = null;

        foreach($eventsInCalendar as $eventInCalendar){
            if($eventInCalendar->id === $eventCreated->id){
                $eventToVerify = $eventInCalendar;
            }
        }

        $this->assertNotEmpty($eventToVerify);

        // assert event matches expectations

        $this->assertSame($eventTitleToUpdate, $eventToVerify->title);
        $this->assertSame($timezoneToSet, $eventToVerify->timezone);
        $this->assertTrue(Helpers::timesMatch($eventToVerify, $startDateToUpdate));
    }

    public function test_delete()
    {
        $calendar = $this->createTestCalendar();

        $calendarId = $calendar->id;

        // assert no events in calendar

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        if(!empty($eventsInCalendar)){
            $this->fail('Events in calendar when there should not be, test aborted because set up is not correct');
        }

        // create event

        $eventTitleToSet = trim($this->faker->sentence, '.');
        $timezoneToSet = $this->faker->timezone;
        $startDateToSet = Carbon::now($timezoneToSet)->addDays(rand(2,20))->addMinutes(rand(0,60*24));

        $eventCreated = $this->eventsHandler->create(
            $calendarId,
            $eventTitleToSet,
            $timezoneToSet,
            $startDateToSet
        );

        // delete event

        $deleteResult = $this->eventsHandler->delete($eventCreated->id);

        $this->assertTrue($deleteResult);

        // fetch events

        $eventsInCalendar = $this->eventsHandler->list($calendarId);

        $this->assertEmpty($eventsInCalendar);

        $found = false;

        foreach($eventsInCalendar as $eventInCalendar){
            if($eventInCalendar->id === $eventCreated->id){
                $found = true;
            }
        }

        $this->assertFalse($found);
    }
}
