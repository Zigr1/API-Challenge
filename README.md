# PHP API
Here is a simple Web API PHP to implement functionality of home assignment. 
# Installation
1.	Clone/download this folder to your computer.
2.	Save this folder in your web-server root directory (it can be ‘htdocs’ folder if you are using XAMPP, for example). Web-server & PHP 5.3+ supposed to be installed on your computer.
# How does it work
You can use the API either from:
1.	A web front-end application (run index.php from the project root directory). It uses a 3d party JS library ‘dtsel’ to implement DateTime picker form field (MIT license).
![API frontend](https://github.com/Zigr1/API-Challenge/blob/main/img/api1.png?raw=true)
2.	Or using the Postman to test HTTP requests and read responses. It can be downloaded there: https://www.postman.com/downloads/. You can use POST or GET method of sending request. Others are not allowed. 
![API in POSTMAN](https://github.com/Zigr1/API-Challenge/blob/main/img/api2.png?raw=true)
### The request should look like this: http://localhost/API-Challenge/api/index.php? 
(or ../API-Challenge-main/.. if you left the branch name)
### There are 6 request parameters:
1.	dateTimeStart: Starting date and time
2.	timeZoneStart: Time zone of starting date and time (full list of supported timezones can be found here: https://www.php.net/manual/en/timezones.php )
3.	dateTimeEnd: Ending date and time
4.	timeZoneEnd: Time zone of ending date and time
5.	measure: Interval measurement (‘d’ for days, ‘wd’ for weekdays, or ‘w’ for complete weeks)
6.	convertTo: One of ‘s’, ’i’, ’h’, or ‘y’ to convert result to seconds, minutes, hours or years respectively (null or ‘-‘ for no convertion).
Response returned is a JSON object.

### You can also run request as http://localhost/API-Challenge/api/[any_custom_route]?[parameters] if you add this lines to the .htaccess file of the project:
RewriteEngine On

RewriteRule ^ index.php [QSA,L]

### API itself consists of two files in ‘api’ folder:
1.	index.php – api access point. It gets parameters from the request, handle input, initialize a new object of a Client class, returns response as a JSON object.
2.	client.class.php – api client that implements the core functionality as a class with properties and methods.
# Decisions and assumptions made for this task
1.	To count days between two DateTime parameters I will use PHP method DateTime::diff() as it is more accurate than do it manually. This method takes into account time zones offsets, day light savings, leap years, etc.
### Assumptions made: 
Count whole days only (that comprise 24 hours)

2. I will count weekdays manually as I couldn't find any 3d party library to do the task.
### Assumptions made:
Weekdays are Monday to Friday;
Any holidays are ignored;
Count whole weekdays only (that comprise 24 hours from 12am to 12am of the next day)

3.	To count complete weeks I can use the result of (1) and take its whole fraction of division by 7.
### Assumptions made: 
Complete week is a period of any 7 consecutive whole days (24hours * 7). Not necessarily Sunday to Saturday.

4.	To receive the result of conversion operation I will use the result of (1), (2) or (3) as an input as it is asked in the assignment. This will assure consistency (always getting the same result, as 2 days is always 24*2 hours or 24*2*60*60 seconds), though finding difference in seconds or hours between two DateTime parameters straightforward would result in a different number.

5.	Time zone offset is taken into account by DateTime::diff() method that I'm going to use.
# Unit tests
‘test’ folder contains php file with unit tests for calculateWeekdaysBetween function that doesn’t use standard php methods.

PHPUnit library was used for running tests. It was installed to the project locally as a Composer dependency. For this reason, the project include composer.json dependencies file and ‘vendor’ folder with PHPUnit software.

PHPUnit installation guide can be found here:
https://phpunit.de/getting-started/phpunit-9.html

To run the test, run the command:
./vendor/bin/phpunit test/DataTest.php

