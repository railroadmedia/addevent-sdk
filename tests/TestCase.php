<?php

namespace Railroad\AddEventSdk\Tests;

use Faker\Factory;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Railroad\AddEventSdk\Entities\Account;
use Railroad\AddEventSdk\Entities\Calendar;
use Railroad\AddEventSdk\Handlers\CalendarsHandler;
use Railroad\AddEventSdk\Handlers\EventsHandler;

class TestCase extends BaseTestCase
{
    protected $apiToken;

    /** @var EventsHandler */
    protected $eventsHandler;

    /** @var \Faker\Generator */
    protected $faker;

    /** @var array */
    protected $calendarsToDeleteAtTearDown;

    /** @var Account */
    private $accountForTestSupport;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = Factory::create();

        $this->apiToken = config('addevent-sdk.api-token');

        $this->accountForTestSupport = new Account();

        $this->deleteAllCalendars();
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

    private function deleteAllCalendars()
    {
        $calendarsWithMoreThanOneFollower = [];

        $calendarsToDelete = $this->accountForTestSupport->calendars();

        foreach($calendarsToDelete as $calendar){
            /** @var $calendar Calendar */
            $moreThanOneFollower = (int) $calendar->getFollowersTotal() > 1;
            if($moreThanOneFollower){
                $calendarsWithMoreThanOneFollower[] = $calendar;
            }
        }

        if(!empty($calendarsWithMoreThanOneFollower)){
            echo 'Test tear-down clean-up calendar-deletion function halted because it found calendars with more ' .
                'followers than expected which is potential indication of production calendars. Double-check your ' .
                'configuration to ensure you\'re not running these tests on production.' . PHP_EOL;
            foreach($calendarsWithMoreThanOneFollower as $calendar){
                echo '* calendar ' . $calendar->getId() . '("' . $calendar->getTitle() . '") has ' . $calendar->getFollowersTotal() . ' followers' . PHP_EOL;
            }
            $this->fail('Calendar deletion halted preemptively, see test output');
        }

        foreach($calendarsToDelete as $calendarToDelete){
            /** @var $calendarToDelete Calendar */
            if(!$calendarToDelete->getMainCalendar()){
                try{
                    $calendarToDelete->delete();
                }catch(\Exception $exception){
                    echo 'Deletion failed for calendar ' . $calendarToDelete->getId() . ' ("' . $calendarToDelete->getTitle() . '") with message: ' . $exception->getMessage();
                    $calendarDeletionFailed = true;
                }
            }
        }

        if($calendarDeletionFailed ?? false){
            $this->fail('Calendar deletion failed, see test output');
        }
    }
}