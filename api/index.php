<?php

	# API access point

	// receive request object
	$route 	= $_SERVER['REQUEST_URI'];
	$method = $_SERVER['REQUEST_METHOD'];

	$result = null;

	// include api client class specification
	include('client.class.php');

	// instantiate new object of the class with parameters values from request object
	try {
		$assignment = new Client($_REQUEST['dateTimeStart'],
					 $_REQUEST['timeZoneStart'],
					 $_REQUEST['dateTimeEnd'],
					 $_REQUEST['timeZoneEnd'],
					 $_REQUEST['meassure'],
					 $_REQUEST['convertTo']
					);

	# Handle wrong input
	} catch(Exception $err) {
		$errorCode = $err->getCode();
		$errorMessage = $err->getMessage();

		// set response code - 422 Wrong input
	    	http_response_code(422);

		// tell the user about wrong input parameter value
		echo json_encode(array('status' => $errorCode, 'message' => $err->getMessage()));
		return;
	}

	// perform appropriate method according to input parameters values
	$result = $assignment->chooseMethod($method,$route);

	// return response in JSON format
	echo json_encode($result);

?>
