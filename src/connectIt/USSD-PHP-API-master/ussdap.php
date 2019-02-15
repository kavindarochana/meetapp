<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
//require 'log.php';
require 'db.php';


$production = false;
$subscriber = false;

if ($production == false) {
	$ussdserverurl = 'http://localhost:7000/ussd/send';
} else {
	$ussdserverurl = 'https://api.dialog.lk/ussd/send';
}


$receiver = new UssdReceiver();
$sender = new UssdSender($ussdserverurl, 'APP_000001', 'password');
$operations = new Operations();

$receiverSessionId = $receiver->getSessionId();
$content = $receiver->getMessage(); // get the message content
$address = $receiver->getAddress(); // get the sender's address
$requestId = $receiver->getRequestID(); // get the request ID
$applicationId = $receiver->getApplicationId(); // get application ID
$encoding = $receiver->getEncoding(); // get the encoding value
$version = $receiver->getVersion(); // get the version
$sessionId = $receiver->getSessionId(); // get the session ID;
$ussdOperation = $receiver->getUssdOperation(); // get the ussd operation


// $responseMsg = array(
// 		 "main" =>  
//     "T-Shirts
// 1. Small
// 2. Medium
// 3. Large

// 99. Exit"
// );

if (!$subscriber) {

	$responseMsg = array(
		"main" =>
			"Welcome to FZone
		
1. Activate

99. Exit"
	);

	if ($ussdOperation == "mo-init") {

		try {

			$sessionArrary = array("sessionid" => $sessionId, "tel" => $address, "menu" => "main", "pg" => "", "others" => "name");

			$operations->setSessions($sessionArrary, $conn);
			error_log(json_encode($sessionArrary));

			$sender->ussd($sessionId, $responseMsg["main"], $address);

		} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again', $address);
		}

	} else {

		$flag = 0;

		$sessiondetails = $operations->getSession($sessionId, $conn);
		$cuch_menu = $sessiondetails['menu'];
		$operations->session_id = $sessiondetails['sessionsid'];

		error_log('aaaaaa' . json_encode($sessiondetails));

		switch ($cuch_menu) {

			case "main": 	// Following is the main menu
				switch ($receiver->getMessage()) {
					case "1":
						$operations->session_menu = "name";
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, 'Enter Your Name', $address);
						break;
					// case "2":
					// 	$operations->session_menu = "medium";
					// 	$operations->saveSesssion($conn);
					// 	$sender->ussd($sessionId, 'Enter Your ID', $address);
					// 	break;
					case "99":
						$operations->session_menu = "large";
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, 'You have successfully exit from FZone', $address, 'mt-fin');
						break;
						break;
					default:
						$operations->session_menu = "main";
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, $responseMsg["main"], $address);
						break;
				}
				break;

			case "name":
				$operations->session_menu = "age-validate";
				$operations->session_others = $receiver->getMessage();
				$operations->saveSesssion($conn);
				$sender->ussd($sessionId, 'Hi ' . $receiver->getMessage() . ' Please enter your Age ', $address, 'mt-fin');
				$operations->setName($receiver->getMessage(), $conn);
				break;

			case 'age-validate':
				if (!ctype_digit($receiver->getMessage())) {
					$operations->session_menu = "age-validate";
					$sender->ussd($sessionId, 'Hi Please enter Valid Age ', $address, 'mt-fin');

				} else {
					error_log('valid');
				//	$sender->ussd($sessionId, 'Please select your sex', $address, 'mt-fin');
					$responseMsg = array(
		"main" =>
			"Please select your sex
1. Male
2. Female
	
99. Exit"
					);
					$sender->ussd($sessionId, $responseMsg["main"], $address);
				}
				break;





			case "large":
				$sender->ussd($sessionId, 'You Purchased a large T-Shirt Your ID ' . $receiver->getMessage(), $address, 'mt-fin');
				break;

			default:
				$operations->session_menu = "main";
				$operations->saveSesssion($conn);
				$sender->ussd($sessionId, 'Incorrect option', $address);
				break;
		}
	}

}