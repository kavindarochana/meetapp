<?php

ini_set('error_log', 'ussd-app-error.log');

require 'libs/MoUssdReceiver.php';
require 'libs/MtUssdSender.php';
require 'class/operationsClass.php';
require 'class/Subscriber.php';
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
$subs = new Subscriber();

$receiverSessionId = $receiver->getSessionId();
$content = $receiver->getMessage(); // get the message content
$address = $receiver->getAddress(); // get the sender's address
$requestId = $receiver->getRequestID(); // get the request ID
$applicationId = $receiver->getApplicationId(); // get application ID
$encoding = $receiver->getEncoding(); // get the encoding value
$version = $receiver->getVersion(); // get the version
$sessionId = $receiver->getSessionId(); // get the session ID;
$ussdOperation = $receiver->getUssdOperation(); // get the ussd operation

$msisdn = trim($address, 'tel:');
$subInfo = $subs->getSubscriber($msisdn, $conn);
error_log('sub info --- ' . json_encode($subInfo));
if (!@$subInfo['msisdn']) {

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

		error_log('session' . json_encode($sessiondetails));
		error_log('menu - ' . $cuch_menu);
		switch ($cuch_menu) {

			case "main": 	// Following is the main menu
				switch ($receiver->getMessage()) {
					case "1":

						$operations->session_menu = "name";
						$operations->saveSesssion($conn, null, $msisdn);
						$sender->ussd($sessionId, 'Enter Your Name', $address);
						break;
					case "99":
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, 'You have successfully exit from FZone', $address, 'mt-fin');
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
				$operations->saveSesssion($conn, 'name', $receiver->getMessage());
				$sender->ussd($sessionId, 'Hi ' . $receiver->getMessage() . ' Please enter your Age ', $address, 'mt-fin');
				//$subs->setUser($receiver->getMessage(), $msisdn, $conn);
				break;

			case 'age-validate':
				if (!ctype_digit($receiver->getMessage())) {

					$sender->ussd($sessionId, 'Hi Please enter Valid Age ', $address, 'mt-fin');
					$operations->session_menu = "age-validate";

				} else {
					error_log('valid');
					//$subs->setAge($a);
				
				//	$sender->ussd($sessionId, 'Please select your sex', $address, 'mt-fin');
					$responseMsg = array(
						"main" =>
							"Please select your sex
1. Male
2. Female
	
99. Exit"
					);
					$sender->ussd($sessionId, $responseMsg["main"], $address);
					$operations->session_menu = "registered";
					$operations->saveSesssion($conn, 'age', $receiver->getMessage());
				}

				break;
			case "registered":
				$operations->saveSesssion($conn, 'sex', $receiver->getMessage());
				$sender->ussd($sessionId, 'You have succefully registerd with FZone, We will update your details via SMS and please redial after few movement ', $address, 'mt-fin');
				break;

			default:
				$operations->session_menu = "main";
				$operations->saveSesssion($conn);
				$sender->ussd($sessionId, 'Incorrect option', $address);
				break;
		}
	}

} else {
	error_log('already registered');

	$responseMsg = [
		"subscriber-init" =>
			'Hi ' . $subInfo['name'] . ' Welcome again to FZone
	
1. Find Friends
2. My Friends
3. My Info

99. Exit',

		"gender-init" => $subInfo['name'] . ' You are looking for 

1. Male
2. Female',
		"age-limit" => ' Select age range for looking for
	
1. 18-30
2. 30-40
3. Above 40
4. Any Age'
	];

	if ($ussdOperation == "mo-init") {
		error_log('subscriber - mo init');
		try {

			$sessionArraryNew = array("sessionid" => $sessionId, "tel" => $address, "menu" => "gender-init", "pg" => "", "others" => "name");

			$operations->setSessions($sessionArraryNew, $conn);
			error_log(json_encode($sessionArraryNew));

			$sender->ussd($sessionId, $responseMsg["subscriber-init"], $address);

		} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again', $address);
		}

	} else {

		$flag = 0;

		$sessiondetails = $operations->getSession($sessionId, $conn);
		$cuch_menu = $sessiondetails['menu'];
		$operations->session_id = $sessiondetails['sessionsid'];

		error_log('session' . json_encode($sessiondetails));
		error_log('subscriber menu - ' . $cuch_menu);
		switch ($cuch_menu) {

			case "main": 	// Following is the main menu
				switch ($receiver->getMessage()) {
					case "1":

						$operations->session_menu = "name";
						$operations->saveSesssion($conn, null, $msisdn);
						$sender->ussd($sessionId, 'Enter Your Name', $address);
						break;
					case "99":
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, 'You have successfully exit from FZone', $address, 'mt-fin');
						break;
					default:
						$operations->session_menu = "main";
						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, $responseMsg["main"], $address);
						break;
				}
				break;

			case "gender-init":

				$operations->session_others = $receiver->getMessage();

				$sender->ussd($sessionId, $responseMsg['gender-init'], $address, 'mt-fin');
				//$subs->setUser($receiver->getMessage(), $msisdn, $conn);

				if ($receiver->getMessage() == 1) {
					error_log('---------male--------------');
					//$sender->ussd($sessionId, $responseMsg["gender-male"], $address);
					$operations->saveSesssion($conn, 'menu', 'gender-male');
					$operations->saveSesssion($conn, 'gender', 1);
					$operations->session_menu = "gender-male";
				} else {
					//$sender->ussd($sessionId, $responseMsg["gender-female"], $address);
					$operations->saveSesssion($conn, 'menu', 'gender-female');
					$operations->saveSesssion($conn, 'gender', 2);
					$operations->session_menu = "gender-female";
				}
				break;

			case "gender-male":
				$sender->ussd($sessionId, $responseMsg['age-limit'], $address, 'mt-fin');
				$operations->saveSesssion($conn, 'age', $receiver->getMessage());
				break;

			case "gender-female":
				$operations->saveSesssion($conn, 'age', $receiver->getMessage());
				$sender->ussd($sessionId, $responseMsg['age-limit'], $address, 'mt-fin');
				break;

			default:
				$operations->session_menu = "main";
				$operations->saveSesssion($conn);
				$sender->ussd($sessionId, 'Incorrect option', $address);
				break;
		}
	}
}
