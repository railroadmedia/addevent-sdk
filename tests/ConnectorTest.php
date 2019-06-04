<?php

use Railroad\AddEventSdk\Tests\TestCase;

class ConnectorTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_get_calendars()
    {
        try{
            $this->connector->getCalendars();
        }catch(\Exception $exception){
            $this->fail($exception->getMessage());
        }

        $this->expectNotToPerformAssertions();
    }

    public function test_get_calendars_assert_count()
    {
        /*
         * This an an extra level of verification that getCalendars is working. For this test to pass you must log into
         * addevent.com and see how many calendars you currently have, and then set TESTING_VALUE_CALENDAR_COUNT as that
         * amount in .env
         *
         * Alternatively, you can omit this test by setting that env var to boolean false.
         */

        if(env('TESTING_VALUE_CALENDAR_COUNT') === false) {
            $this->markTestSkipped('Optional test currently configured to be skipped');
        }

        try{
            $calendars = $this->connector->getCalendars();
        }catch(\Exception $exception){
            $this->fail($exception->getMessage());
        }

        $this->assertCount(env('TESTING_VALUE_CALENDAR_COUNT'), $calendars ?? []);
    }
}
