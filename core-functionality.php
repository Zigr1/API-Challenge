<?php
/**
* Assignment class to implement task functionality
*/
class Assignment
{
	//Attributes
	private $dateTimeStart;
	private $dateTimeEnd;
	private $timeZoneStart;
	private $timeZoneEnd;
	private $meassure;
	private $convertTo;

	//Methods
	function __construct($dateTimeStart = '',
						 $timeZoneStart ='',
						 $dateTimeEnd = '',
						 $timeZoneEnd ='',
						 $meassure = '',
						 $convertTo = '')
	{
		# Construct the class and set the values in the attributes.
		$this->timeZoneStart = new DateTimeZone($timeZoneStart);
		$this->dateTimeStart = new DateTime($dateTimeStart, $this->timeZoneStart);
		$this->timeZoneEnd = new DateTimeZone($timeZoneEnd);
		$this->dateTimeEnd = new DateTime($dateTimeEnd, $this->timeZoneEnd);
		$this->meassure = $meassure;
		$this->convertTo = $convertTo;

	}

	// 1. count number of days between two dates
	function calculateDaysBetween(DateTime $date1, DateTime $date2) {
		return $date1->diff($date2)->format('%a');

	}

	// 2. count number of weekdays between two dates
	function calculateWeekdaysBetween(DateTime $date1, DateTime $date2) {

		// 2.1 count number of weekdays from start of week to start date
		$dayStart = $date1->format('w');
		// transfer Sunday to the end of week
        if ($dayStart == 0)
            $dayStart = 7;
        // weekdays from start of the week before start date
        $wdayStart = $dayStart > 5 ? 5 : $dayStart;

        // 2.2 count number of weekdays from start of week to end date
        $dayEnd = $date2->format('w');
        // transfer Sunday to the end of week
        if ($dayEnd == 0)
            $dayEnd = 7;
        // weekdays from start of the week before end date
        $wdayEnd = $dayEnd > 5 ? 5 : ($dayEnd - 1);

        // 2.3 count number of full weeks between the two dates
        $weeksBetween = self::calculateCompleteWeeksBetween($date1, $date2);

        // 2.4 count number of weekdays between two dates as sum of previous results
        $weekdaysBetween = 5 * ($weeksBetween - 1) + (5 - $wdayStart) + $wdayEnd;

        return $weekdaysBetween;

	}

	// 3. count number of complete weeks between two dates
	function calculateCompleteWeeksBetween(DateTime $date1, DateTime $date2) {
		$daysBetween = self::calculateDaysBetween($date1, $date2);
		return floor($daysBetween / 7);

	}

	// 4. convert result of (1), (2) or (3) into seconds, minutes, hours or years
	function convertResult($result, $param) {
		switch ($param) {
			// convert to seconds
			case 's':
				return $result * (60*60*24);
			// convert to minutes
			case 'i':
				return $result * (60*24);
			// convert to hours
			case 'h':
				return $result * (24);
			// convert to years
			case 'y':
				return round($result / (365), 3);
			// don't convert
			default:
				return $result;
		}
	}

}

?>