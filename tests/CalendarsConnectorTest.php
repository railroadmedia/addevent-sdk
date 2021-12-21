<?php

use Railroad\AddEventSdk\Tests\TestCase;

class CalendarsConnectorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_create()
    {
        $title = $this->faker->sentence();
        $description = $this->faker->text();

        $calendar = $this->createTestCalendar($title, $description);

        $this->assertTrue(is_numeric($calendar->id));
        $this->assertTrue(!empty($calendar->uniquekey));
        $this->assertSame($title, $calendar->title);
        $this->assertSame($description, $calendar->description);
    }

    public function test_read()
    {
        $numberOfCalendarsToCreateForTest = rand(2,4);

        for($i = 0; $i < $numberOfCalendarsToCreateForTest; $i++){
            $title = $this->faker->sentence();
            $description = $this->faker->text();
            $calendar = $this->createTestCalendar($title, $description);

            if($title !== $calendar->title || $description !== $calendar->description){
                $this->assertSame($title, $calendar->title);
                $this->assertSame($description, $calendar->description);
            }

            $expectedCalendars[$calendar->id] = $calendar;
        }

        if(count($expectedCalendars) !== $numberOfCalendarsToCreateForTest){
            $this->assertEquals(count($expectedCalendars), $numberOfCalendarsToCreateForTest);
        }

        $calendarsRetrieved = $this->fetchAllCalendars();

        $this->assertEquals($numberOfCalendarsToCreateForTest, count($calendarsRetrieved));

        foreach($calendarsRetrieved as $calendarRetrieved){
            $expectedCalendar = $expectedCalendars[$calendarRetrieved->id];

            $this->assertSame($expectedCalendar->id, $calendarRetrieved->id);
            $this->assertSame($expectedCalendar->uniquekey, $calendarRetrieved->uniquekey);
            $this->assertSame($expectedCalendar->title, $calendarRetrieved->title);
            $this->assertSame($expectedCalendar->description, $calendarRetrieved->description);
            $this->assertSame($expectedCalendar->followers_active, $calendarRetrieved->followers_active);
            $this->assertSame($expectedCalendar->followers_total, $calendarRetrieved->followers_total);
            $this->assertSame($expectedCalendar->events_total, $calendarRetrieved->events_total);
            $this->assertSame(empty($expectedCalendar->custom_data), empty($calendarRetrieved->custom_data)); // one returns literal null, the other returns empty string. Such is life.
            $this->assertSame($expectedCalendar->template_id, $calendarRetrieved->template_id);
            $this->assertSame($expectedCalendar->link_short, $calendarRetrieved->link_short);
            $this->assertSame($expectedCalendar->link_long, $calendarRetrieved->link_long);
            $this->assertSame($expectedCalendar->date_create, $calendarRetrieved->date_create);
            $this->assertSame($expectedCalendar->date_modified, $calendarRetrieved->date_modified);

            //$this->assertSame(false, $calendarRetrieved->main_calendar); // todo: how to determine what this should be?
        }
    }

    public function test_update()
    {
        $this->markTestIncomplete('to do');
    }

    public function test_delete()
    {
        $title = $this->faker->sentence();
        $description = $this->faker->text();
        $calendar = $this->createTestCalendar($title, $description);

        if($title !== $calendar->title || $description !== $calendar->description){
            $this->assertSame($title, $calendar->title);
            $this->assertSame($description, $calendar->description);
        }

        $countBeforeDeletion = count($this->fetchAllCalendars());

        $deletionResult = $this->calendarsConnector->delete($calendar->id);

        $countAfterDeletion = count($this->fetchAllCalendars());
        $expectedCountAfterDeletion = $countBeforeDeletion - 1;

        $this->assertEquals($expectedCountAfterDeletion, $countAfterDeletion);
    }
}
