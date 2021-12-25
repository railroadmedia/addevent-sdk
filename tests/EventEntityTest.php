<?php

namespace Railroad\AddEventSdk\Tests;

use Carbon\Carbon;
use Railroad\AddEventSdk\Entities\Account;
use Railroad\AddEventSdk\Entities\Calendar;
use Railroad\AddEventSdk\Entities\Event;

class EventEntityTest extends TestCase
{
    public function test_retrieve_from_calendar()
    {
        $account = new Account();

        $titleOriginal = $this->faker->sentence();
        $descriptionOriginal = $this->faker->text();
        $calendar = $account->createCalendar($titleOriginal, $descriptionOriginal);
        $idOfCalendarToUse = $calendar->getId();

        $calendars = $account->calendars();

        $this->assertEquals(2, count($calendars));

        foreach($calendars as $calendarCandidate){
            if($calendarCandidate->getId() === $idOfCalendarToUse){
                $calendar = $calendarCandidate;
            }
        }

        /** @var Calendar $calendar */
        $calendar = $calendars->first();
        $events = $calendar->events();
        $this->assertEquals(0, count($events));

        $numberToCreate = rand(2,5);

        for($i = 0; $i < $numberToCreate; $i++){
            $timezone = $this->faker->timezone;
            $calendar->createEvent(
                rtrim($this->faker->sentence(), '.'),
                $timezone,
                Carbon::now($timezone)->addDays(rand(4,20))->addHours(rand(0,23))->addMinutes(rand(0,59))
            );
        }

        $events = $calendar->events();

        $this->assertEquals($numberToCreate, count($events));
    }

    public function test_persist()
    {
        $calendarTitle = rtrim($this->faker->sentence(), '.');
        $calendarDescription = $this->faker->text();
        $account = new Account();
        $calendar = $account->createCalendar($calendarTitle, $calendarDescription);

        $eventTitleOriginal = rtrim($this->faker->sentence(), '.');
        $eventTitleNew = rtrim($this->faker->sentence(), '.');
        $eventTimezone = $this->faker->timezone;
        $eventStartTimeOriginal = Carbon::now($eventTimezone)->addDays(rand(4,20))->addHours(rand(0,23))->addMinutes(rand(0,59));
        $eventStartTimeNew = Carbon::now($eventTimezone)->addDays(rand(4,20))->addHours(rand(0,23))->addMinutes(rand(0,59));

        $countBefore = count($calendar->events());

        $event = $calendar->createEvent($eventTitleOriginal, $eventTimezone, $eventStartTimeOriginal);

        /** @var Event $eventPulledFreshlyBeforePersist */
        $eventPulledFreshlyBeforePersist = $calendar->events()->first();
        $this->assertSame(
            $eventStartTimeOriginal->toDateTimeString(),
            $eventPulledFreshlyBeforePersist->getStart()->toDateTimeString()
        );

        $event->setTitle($eventTitleNew);
        $event->setStart($eventStartTimeNew);
        $event->persist();

        /** @var Event $eventPulledFreshlyAfterPersist */
        $eventPulledFreshlyAfterPersist = $calendar->events()->first();
        $this->assertSame(
            $eventStartTimeNew->toDateTimeString(),
            $eventPulledFreshlyAfterPersist->getStart()->toDateTimeString()
        );

        $countAfter = count($calendar->events());

        $this->assertSame(0, $countBefore);
        $this->assertSame(1, $countAfter);

        $eventsFresh = $calendar->events();
        if(count($eventsFresh) < 1){
            $this->fail('Calendar had more events than expected. If this repeats the test meez is broken, if not it\'s flawed.');
        }
        /** @var Event $eventFresh */
        $eventFresh = $eventsFresh->first();
        $this->assertSame($eventTitleNew, $eventFresh->getTitle());
    }

    public function test_delete()
    {
        $account = new Account();

        $titleOriginal = $this->faker->sentence();
        $descriptionOriginal = $this->faker->text();
        $calendar = $account->createCalendar($titleOriginal, $descriptionOriginal);
        $idOfCalendarToUse = $calendar->getId();

        $calendars = $account->calendars();

        $this->assertEquals(2, count($calendars));

        foreach($calendars as $calendarCandidate){
            if($calendarCandidate->getId() === $idOfCalendarToUse){
                $calendar = $calendarCandidate;
            }
        }

        /** @var Calendar $calendar */
        $calendar = $calendars->first();
        $events = $calendar->events();
        $this->assertEquals(0, count($events));

        $numberToCreate = rand(2,5);

        for($i = 0; $i < $numberToCreate; $i++){
            $timezone = $this->faker->timezone;
            $calendar->createEvent(
                rtrim($this->faker->sentence(), '.'),
                $timezone,
                Carbon::now($timezone)->addDays(rand(4,20))->addHours(rand(0,23))->addMinutes(rand(0,59))
            );
        }

        $events = $calendar->events();

        $this->assertEquals($numberToCreate, count($events));

        /** @var Event $eventToDelete */
        $eventToDelete = $events->last();
        $eventToDelete->delete();

        $events = $calendar->events();

        $this->assertEquals($numberToCreate-1, count($events));
    }
}