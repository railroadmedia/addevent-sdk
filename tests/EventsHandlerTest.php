<?php

use Carbon\Carbon;
use Railroad\AddEventSdk\Helpers;
use Railroad\AddEventSdk\Tests\TestCase;

// todo: add test cases where more params are specified when creating events

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

        $this->assertNotEmpty($eventCreated->id);
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
        $this->markTestIncomplete();
    }

    public function test_delete()
    {
        $this->markTestIncomplete();
    }
}
