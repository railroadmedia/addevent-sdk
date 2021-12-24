<?php

namespace Railroad\AddEventSdk\Tests;

use Railroad\AddEventSdk\Entities\Account;
use Railroad\AddEventSdk\Entities\Calendar;

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
            $calendar->persist();
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

        $calendarMalformed = !is_numeric($calendar->getId())
            || empty($calendar->getUniqueKey())
            || ($title !== $calendar->getTitle())
            || $description !== $calendar->getDescription();
        if($calendarMalformed){
            $this->assertTrue(is_numeric($calendar->getId()));
            $this->assertTrue(!empty($calendar->getUniqueKey()));
            $this->assertSame($title, $calendar->getTitle());
            $this->assertSame($description, $calendar->getDescription());
        }

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
}