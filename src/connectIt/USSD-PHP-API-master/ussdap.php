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
	$gender = $subInfo['sex'] == '1' ? 'Male':'Female';
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
		"age-limit" => 'Select age range for looking for
	
1. 18-30
2. 30-40
3. Above 40
4. Any Age',

'user-info' => 'Name : '.$subInfo['name'].',
UID : '.$subInfo['id'].'
Age : '.$subInfo['age'].',
Gender : '.$gender.'

93. Back',
	];

	if ($ussdOperation == "mo-init") {
		error_log('subscriber - mo init');
		try {

			error_log('enter--------' . $receiver->getMessage());
			$sessionArraryNew = array("sessionid" => $sessionId, "tel" => $address, "menu" => "main", "pg" => "", "others" => "name");

			$operations->setSessions($sessionArraryNew, $conn);
			error_log(json_encode($sessionArraryNew));

			//Response to user
			$sender->ussd($sessionId, $responseMsg["subscriber-init"], $address);

		} catch (Exception $e) {
			$sender->ussd($sessionId, 'Sorry error occured try again', $address);
		}

	} else {

		error_log('------------sub continue----------------');
		error_log('------------pressed---------------'.$receiver->getMessage());

		$sessiondetails = $operations->getSession($sessionId, $conn);
		$cuch_menu = $sessiondetails['menu'];
		$operations->session_id = $sessiondetails['sessionsid'];

		error_log("rcvr -".$receiver->getMessage().'***** cuch===='.$sessiondetails['menu']);
		if ($receiver->getMessage() == 93 &&  $sessiondetails['menu'] == "main") {
			$sessionArraryNew = array("sessionid" => $sessionId, "tel" => $address, "menu" => "main", "pg" => "", "others" => "name");

			$operations->setSessions($sessionArraryNew, $conn);
			error_log(json_encode($sessionArraryNew));

			//Response to user
			$sender->ussd($sessionId, $responseMsg["subscriber-init"], $address);
		}

		if ($receiver->getMessage() == 92 &&  $sessiondetails['menu'] == "friend-list-1") {
			$cuch_menu = 'friend-list-2';
			error_log('-------------------92 flist 1');
		} 

		if ($receiver->getMessage() == 93 &&  $sessiondetails['menu'] == "friend-list-2") {
			$cuch_menu = 'friend-list-1';
		}

		if ($receiver->getMessage() == 92 &&  $sessiondetails['menu'] == "friend-list-2") {
			$cuch_menu = 'friend-list-3';
		}
		
		if ($receiver->getMessage() == 93 &&  $sessiondetails['menu'] == "friend-list-3") {
			$cuch_menu = 'friend-list-2';
		}

		if ($receiver->getMessage() <= 15 &&  ($sessiondetails['menu'] == "friend-list-1" || $sessiondetails['menu'] == "friend-list-2" || $sessiondetails['menu'] == "friend-list-3")) {
			$sender->ussd($sessionId, 'reque', $address);
			return;
		}
		

		error_log('session' . json_encode($sessiondetails));
		error_log('subscriber menu - ' . $cuch_menu);
		switch ($cuch_menu) {

			case "main": 	// Following is the main menu
				switch ($receiver->getMessage()) {
					case "1":

						$operations->session_menu = "gender-init";
						$sender->ussd($sessionId, $responseMsg['gender-init'], $address);
						$operations->saveSesssion($conn, 'menu', 'gender-init');
						break;

					case "2":

						$operations->session_menu = "gender-init";;
						$sender->ussd($sessionId, $responseMsg['gender-init'], $address);
						break;

					case "3":

						$operations->session_menu = "user-info";
						$sender->ussd($sessionId, $responseMsg['user-info'], $address);
						break;
					case "99":

						$operations->saveSesssion($conn);
						$sender->ussd($sessionId, 'You have successfully exit from FZone', $address, 'mt-fin');
						break;

				}
				break;

			case "gender-init":
				error_log('---------gender--------------check');
				$operations->session_others = $receiver->getMessage();

				$sender->ussd($sessionId, $responseMsg['age-limit'], $address, 'mt-fin');
				//$subs->setUser($receiver->getMessage(), $msisdn, $conn);

				if ($receiver->getMessage() == 1) {
					error_log('---------male--------------');
					//$sender->ussd($sessionId, $responseMsg["gender-male"], $address);
					$operations->saveSesssion($conn, 'menu', 'age-init');
					$operations->saveSesssion($conn, 'gender', 1);
					$operations->session_menu = "age-init";

				} else {
					error_log('---------female--------------');
					//$sender->ussd($sessionId, $responseMsg["gender-female"], $address);
					$operations->saveSesssion($conn, 'menu', 'age-init');
					$operations->saveSesssion($conn, 'gender', 2);
					$operations->session_menu = "age-init";
				}
				break;

			// case "gender-male":
			// 	$sender->ussd($sessionId, 'male', $address, 'mt-fin');
			// 	//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// 	break;

			// case "gender-female":
			// 	//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// 	$sender->ussd($sessionId, 'female', $address, 'mt-fin');
			// 	break;

			case "age-init":
				//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
				$sender->ussd($sessionId, $responseMsg['age-limit'], $address, 'mt-fin');
				// $operations->saveSesssion($conn, 'menu', 'friend-list-1');
				$operations->saveSesssion($conn, 'age', $receiver->getMessage());
				// $operations->session_menu = "age-init";
				if($receiver->getMessage() == '1' ) {error_log('aa---$'.$receiver->getMessage());
					$operations->saveSesssion($conn, 'menu', 'friend-list-1');
					//$operations->session_menu = "friend-list-1";
					$sender->ussd($sessionId,  $operations->getFriends($conn, 1, $subInfo['id']), $address, 'mt-fin');
				}else if($receiver->getMessage() == '2'){
					$operations->saveSesssion($conn, 'menu', 'friend-list-2');
					//$operations->session_menu = "friend-list-1";
					$sender->ussd($sessionId, 'friend 2', $address);
				} else {
					$operations->saveSesssion($conn, 'menu', 'friend-list-3');
					//$operations->session_menu = "friend-list-1";
					$sender->ussd($sessionId, 'friend 3', $address);
				}
				break;

			case "friend-list-1":
			//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			error_log('flist 1');
			error_log(json_encode($operations->getFriends($conn, 1, $subInfo['id'])));
			//$sender->ussd($sessionId, $responseMsg['friend-list-1'], $address, 'mt-fin');
			$sender->ussd($sessionId, $operations->getFriends($conn, 1, $subInfo['id']), $subInfo['id'], $address, 'mt-fin');
			
			$operations->saveSesssion($conn, 'menu', 'friend-list-1');
			// $operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// $operations->session_menu = "age-init";
			break;	

			case "friend-list-2":
			error_log('flist 2');
			//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			$sender->ussd($sessionId,  $operations->getFriends($conn, 2, $subInfo['id']), $address, 'mt-fin');
			$operations->saveSesssion($conn, 'menu', 'friend-list-2');
			// $operations->saveSesssion($conn, 'menu', 'friend-list-1');
			// $operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// $operations->session_menu = "age-init";
			break;

			case "friend-list-3":
			error_log('flist 3');
			//$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			$sender->ussd($sessionId,  $operations->getFriends($conn, 3, $subInfo['id']), $address, 'mt-fin');
			$operations->saveSesssion($conn, 'menu', 'friend-list-3');
			// $operations->saveSesssion($conn, 'menu', 'friend-list-1');
			// $operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// $operations->session_menu = "age-init";
			break;

			// case "qqq":
			// 	$operations->saveSesssion($conn, 'age', $receiver->getMessage());
			// 	$sender->ussd($sessionId, 'aaaaaa', $address);
			// 	break;

			default:
				$operations->session_menu = "main";
				$operations->saveSesssion($conn);
				$sender->ussd($sessionId, 'Incorrect option', $address);
				break;
		}
	}
}
