<?php

namespace Railroad\AddEventSdk\Tests;

use Carbon\Carbon;
use Railroad\AddEventSdk\Entities\Account;

class CalendarEntityTest extends TestCase
{
    public function test_persist()
    {
        $titleOriginal = $this->faker->sentence();
        $titleNew = $this->faker->sentence();
        $descriptionOriginal = $this->faker->text();
        $descriptionNew = $this->faker->text();
        $account = new Account();

        $calendar = $account->createCalendar($titleOriginal, $descriptionOriginal);

        $calendarMalformed = !is_numeric($calendar->getId())
            || empty($calendar->getUniqueKey())
            || ($titleOriginal !== $calendar->getTitle())
            || $descriptionOriginal !== $calendar->getDescription();
        if($calendarMalformed){
            $this->assertTrue(is_numeric($calendar->getId()));
            $this->assertTrue(!empty($calendar->getUniqueKey()));
            $this->assertSame($titleOriginal, $calendar->getTitle());
            $this->assertSame($descriptionOriginal, $calendar->getDescription());
        }

        $calendar->setTitle($titleNew);
        $calendar->setDescription($descriptionNew);
        try{
            $calendar->persist(true);
        }catch(\Exception $exception){
            $this->fail('exception message: ' . $exception->getMessage());
        }

        $this->expectNotToPerformAssertions();
    }

    public function test_delete()
    {
        $title = $this->faker->sentence();
        $description = $this->faker->text();
        $account = new Account();
        $calendar = $account->createCalendar($title, $description);

        $countBefore = count($account->calendars());

        try{
            $calendar->delete();
        }catch(\Exception $e){
            $this->fail('exception message: ' . $e->getMessage());
        }

        $countAfter = count($account->calendars());
        $this->assertSame(($countBefore - 1), $countAfter);

        $this->assertNull($calendar->getId());
        $this->assertNull($calendar->getUniqueKey());
        $this->assertNull($calendar->getTitle());
        $this->assertNull($calendar->getDescription());
        $this->assertNull($calendar->getTimezone());
        $this->assertNull($calendar->getWeekdayBegin());
        $this->assertNull($calendar->getCalendarColor());
        $this->assertNull($calendar->getPaletteId());
        $this->assertNull($calendar->getFollowersActive());
        $this->assertNull($calendar->getFollowersTotal());
        $this->assertNull($calendar->getEventsTotal());
        $this->assertNull($calendar->getCustomData());
        $this->assertNull($calendar->getTemplateId());
        $this->assertNull($calendar->getTemplateEmbedId());
        $this->assertNull($calendar->getLinkShort());
        $this->assertNull($calendar->getLinkLong());
        $this->assertNull($calendar->getDateCreate());
        $this->assertNull($calendar->getDateModified());
    }

    public function test_create_event()
    {
        $calendarTitle = rtrim($this->faker->sentence(), '.');
        $calendarDescription = $this->faker->text();
        $account = new Account();
        $calendar = $account->createCalendar($calendarTitle, $calendarDescription);

        $this->assertEquals(0, count($calendar->events()));

        $eventTitle = rtrim($this->faker->sentence(), '.');
        $eventTimezone = $this->faker->timezone;
        $eventStartTime = Carbon::now($eventTimezone)->addDays(rand(4,20))->addHours(rand(0,23))->addMinutes(rand(0,59));
        $event = $calendar->createEvent($eventTitle, $eventTimezone, $eventStartTime);
        $this->assertSame($eventTitle, $event->getTitle());
        $this->assertSame($eventTimezone, $event->getTimezone());
        $this->assertSame($eventStartTime->toDateTimeString(), $event->getStart()->toDateTimeString());

        $this->assertEquals(1, count($calendar->events()));
    }
}