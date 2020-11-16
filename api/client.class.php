<?php
/**
* Client class to implement task functionality
*/
class Client
{
	//Attributes
	private $dateTimeStart;
	private $dateTimeEnd;
	private $timeZoneStart;
	private $timeZoneEnd;
	private $meassure;
	private $convertTo;
	private $method;
	private $array = ['d' => 'days',
					  'wd' => 'weekdays',
					  'w' => 'complete weeks',
					  's' => 'seconds',
					  'i' => 'minutes',
					  'h' => 'hours',
					  'y' => 'years',
					  '-' => 'none'
					];

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
		$this->convertTo = (is_null($convertTo) || $convertTo === '' ? '-' : $convertTo);

	}

	// 0. Choose appropriate method of calculation depending on the meassurement requested
	function chooseMethod($method,$route){
		switch ($this->meassure) {
			case 'd':
				$result = self::calculateDaysBetween($this->dateTimeStart, $this->dateTimeEnd);
				$resultInDays = $result;
				break;
			case 'wd':
				$result = self::calculateWeekdaysBetween($this->dateTimeStart, $this->dateTimeEnd);
				$resultInDays = $result;
				break;
			case 'w':
				$result = self::calculateCompleteWeeksBetween($this->dateTimeStart, $this->dateTimeEnd);
				$resultInDays = $result * 7;
				break;
			default:
				// set response code - 422 Wrong inputd
			    http_response_code(422);

			    // tell the user no products found
			    return array('status' => 422, 'message' => 'Calculation meassure not recognized.');
		}

		$convertedResult = self::convertResult($result, $resultInDays, $this->convertTo);

		// set response code - 200 Success
    	http_response_code(200);

		return 	array('staring date' => $this->dateTimeStart->format('Y-m-d H-i-s'),
					 'starting date timezone' => $this->timeZoneStart,
					 'end date' => $this->dateTimeEnd->format('Y-m-d H-i-s'),
					 'end date timezone' => $this->timeZoneEnd,
					 'difference between dates' => $convertedResult,
					 'difference in' => $this->array[$this->meassure],
					 'difference converted to' => $this->array[$this->convertTo]);

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
	function convertResult($result, $resultInDays, $param) {
		switch ($param) {
			// convert to seconds
			case 's':
				return $resultInDays * (60*60*24);
			// convert to minutes
			case 'i':
				return $resultInDays * (60*24);
			// convert to hours
			case 'h':
				return $resultInDays * (24);
			// convert to years
			case 'y':
				return round($resultInDays / (365), 3);
			// don't convert
			default:
				return $result;
		}
	}

}

?>