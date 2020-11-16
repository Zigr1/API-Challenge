<?php

	# API access point

	// receive request object
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];

	$result = null;

	// include Assignment class specification
	include('client.class.php');

	// instantiate new object of Assignment class with parameters values from request object
	$assignment = new Client($_REQUEST['dateTimeStart'],
							 $_REQUEST['timeZoneStart'],
							 $_REQUEST['dateTimeEnd'],
							 $_REQUEST['timeZoneEnd'],
							 $_REQUEST['meassure'],
							 $_REQUEST['convertTo']
							);

	// perform appropriate method according to input parameters values
	$result = $assignment->chooseMethod($method,$route);

	// return response in JSON format
	echo json_encode($result);

?>