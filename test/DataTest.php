<?php
use PHPUnit\Framework\TestCase;

class DataTest extends TestCase
{

    /**
     * @dataProvider countProvider
     */

    // test for CalculateWeekdaysBetween function
    public function testCalculateWeekdaysBetween($dateTimeStart,
                                                $timeZoneStart,
                                                $dateTimeEnd,
                                                $timeZoneEnd,
                                                $meassure,
                                                $expected) 
    {

        $assignment = new Client($dateTimeStart,
                                    $timeZoneStart,
                                    $dateTimeEnd,
                                    $timeZoneEnd,
                                    $meassure
                                );
           
        $this->assertEquals($expected, $assignment->calculateWeekdaysBetween());

    }

    public function countProvider() {
        require('api\client.class.php');

        return
        //test cases
        array(  

            // test cases for start day before and after end day
            array('dateTimeStart' => '04-11-2020 10:30:00',
                            'timeZoneStart' => 'Australia/Sydney',
                            'dateTimeEnd' => '30-11-2020 14:30:00',
                            'timeZoneEnd' => 'Australia/Sydney',
                            'meassure' => 'wd',
                            'expected' => 17
            ),
            array('dateTimeStart' => '30-11-2020 14:30:00',
                            'timeZoneStart' => 'Australia/Sydney',
                            'dateTimeEnd' => '04-11-2020 10:30:00',
                            'timeZoneEnd' => 'Australia/Sydney',
                            'meassure' => 'wd',
                            'expected' => 17
            ),

            // test cases when one of date is Sun to Sat
            array('dateTimeStart' => '04-11-2020 10:30:00',
                            'timeZoneStart' => 'Australia/Sydney',
                            'dateTimeEnd' => '29-11-2020 14:30:00',
                            'timeZoneEnd' => 'Australia/Sydney',
                            'meassure' => 'wd',
                            'expected' => 17
            ),
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '28-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 17
            ),
            array('dateTimeStart' => '04-11-2020 15:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '27-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 16
            ),
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '26-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 15
            ),
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '25-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 14
            ),
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '24-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 13
            ),

            // test cases for DateTime in different time zones
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'America/Los_Angeles',
                                'dateTimeEnd' => '24-11-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => (13-1)
            ),
            array('dateTimeStart' => '04-11-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '24-11-2020 14:30:00',
                                'timeZoneEnd' => 'America/Los_Angeles',
                                'meassure' => 'wd',
                                'expected' => (13+1)
            ),

            //test case for 0 result
            array('dateTimeStart' => '28-02-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '02-03-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 0
            ),

            //test case for leap year
            array('dateTimeStart' => '28-02-2020 10:30:00',
                                'timeZoneStart' => 'Australia/Sydney',
                                'dateTimeEnd' => '03-03-2020 14:30:00',
                                'timeZoneEnd' => 'Australia/Sydney',
                                'meassure' => 'wd',
                                'expected' => 1
            )
        );

    }

}
?>