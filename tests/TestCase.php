<?php

namespace Railroad\AddEventSdk\Tests;

use Faker\Factory;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Railroad\AddEventSdk\CalendarsConnector;
use Railroad\AddEventSdk\EventsConnector;

class TestCase extends BaseTestCase
{
    protected $apiToken;

    /** @var CalendarsConnector */
    protected $calendarsConnector;

    /** @var EventsConnector */
    protected $eventsConnector;

    /** @var \Faker\Generator */
    protected $faker;

    /** @var array */
    protected $calendarsToDeleteAtTearDown;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->apiToken = config('addevent-sdk.api-token');

        $this->calendarsConnector = app(CalendarsConnector::class);
        $this->eventsConnector = app(EventsConnector::class);
    }

    protected function tearDown(): void
    {
        $this->deleteAllCalendars();

        parent::tearDown();
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application $app
     * @return void
     *
     * This is called *before* setUp
     */
    protected function getEnvironmentSetUp($app)
    {
        $dotenv = \Dotenv\Dotenv::create(__DIR__ . '/../');
        $dotenv->load();

        config()->set('addevent-sdk.api-token', env('ADD_EVENT_API_TOKEN'));
    }

    /*
     * Use this to check that the tests are running
     */
    public function test_call_API()
    {
        try{
            $this->calendarsConnector->get();
        }catch(\Exception $exception){
            $this->fail($exception->getMessage());
        }

        $this->expectNotToPerformAssertions();
    }

    protected function createTestCalendar($title = null, $description = null)
    {
        if(!$title){
            $title = $this->faker->sentence();
        }
        if(!$description){
            $description = $this->faker->text();
        }

        try{
            $calendar = $this->calendarsConnector->create($title, $description);
        }catch(\Exception $exception){
            $this->fail('Calendar creation failed. Exception message: "' . $exception->getMessage() . '"');
        }

        $this->calendarsToDeleteAtTearDown[] = $calendar->id;

        return $calendar;
    }

    protected function fetchAllCalendars()
    {
        try{
            $calendarsRetrieved = $this->calendarsConnector->list();
        }catch(\Exception $exception){
            $this->fail('Calendar list failed. Exception message: "' . $exception->getMessage() . '"');
        }

        return $calendarsRetrieved;
    }

    private function deleteAllCalendars()
    {
        $calendarsWithMoreThanOneFollower = [];

        $calendarsToDelete = $this->fetchAllCalendars();

        foreach($calendarsToDelete as $calendar){
            $moreThanOneFollower = (int) $calendar->followers_total > 1;
            if($moreThanOneFollower){
                $calendarsWithMoreThanOneFollower[] = $calendar;
            }
        }

        if(!empty($calendarsWithMoreThanOneFollower)){
            echo 'Test tear-down clean-up calendar-deletion function halted because it found calendars with more ' .
                'followers than expected which is potential indication of production calendars. Double-check your ' .
                'configuration to ensure you\'re not running these tests on production.' . PHP_EOL;
            foreach($calendarsWithMoreThanOneFollower as $calendar){
                echo '* calendar ' . $calendar->id . '("' . $calendar->title . '") has ' . $calendar->followers_total . ' followers' . PHP_EOL;
            }
            $this->fail('Calendar deletion halted preemptively, see test output');
        }

        foreach($calendarsToDelete as $calendarToDelete){
            if(!$calendarToDelete->main_calendar){
                try{
                    $this->calendarsConnector->delete($calendarToDelete->id);
                }catch(\Exception $exception){
                    echo 'Deletion failed for calendar ' . $calendarToDelete->id . ' ("' . $calendarToDelete->title . '") with message: ' . $exception->getMessage();
                    $calendarDeletionFailed = true;
                }
            }
        }

        if($calendarDeletionFailed ?? false){
            $this->fail('Calendar deletion failed, see test output');
        }
    }
}