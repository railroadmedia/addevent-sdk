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

    public function test_get_timezones()
    {
        $account = new Account();
        $timezones = $account->getTimezones();
        $foo = 'bar';
    }

    public function test_does_faker_ever_give_a_timezone_not_used_by_addevent()
    {
        $account = new Account();
        $timezones = $account->getTimezones();

        for($i=0; $i < 100000; $i++){
            $timezone = $this->faker->timezone;
            if(!in_array($timezone, $timezones)){
                $found[] = $timezone;
            }
        }

        $found = array_values(array_unique($found ?? []));

        // var_dump($found);

        $this->assertSame(2, count($found));
        $this->assertTrue(in_array('Australia/Currie', $found));
        $this->assertTrue(in_array('Pacific/Enderbury', $found));
    }
}