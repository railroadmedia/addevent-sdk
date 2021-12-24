<?php

namespace Railroad\AddEventSdk\Tests;

use Railroad\AddEventSdk\Entities\Account;

class AccountEntityTest extends TestCase
{
    public function test_get_calendars()
    {
        try{
            $account = new Account();
            $calendars = $account->Calendars();
        }catch(\Exception $e){
            $this->fail('exception message is : ' . $e->getMessage());
        }

        $this->assertNotEmpty($calendars);
    }

    public function test_create_calendar()
    {
        $title = $this->faker->sentence();
        $description = $this->faker->text();
        $account = new Account();

        $calendar = $account->createCalendar($title, $description);

        $this->assertTrue(is_numeric($calendar->getId()));
        $this->assertTrue(!empty($calendar->getUniqueKey()));
        $this->assertSame($title, $calendar->getTitle());
        $this->assertSame($description, $calendar->getDescription());
    }
}