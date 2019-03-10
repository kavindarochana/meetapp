<?php
// ==========================================
// Ideamart : Sample PHP SMS API
// ==========================================
// Author : Pasindu De Silva
// Licence : MIT License
// http://opensource.org/licenses/MIT
// ==========================================

ini_set('error_log', 'sms-app-error.log');
require_once 'lib/Log.php';
require_once 'lib/SMSReceiver.php';
require_once 'lib/SMSSender.php';

define('SERVER_URL', 'http://localhost:7000/sms/send');	
define('APP_ID', 'APPID');
define('APP_PASSWORD', 'password');
require 'db.php';

$logger = new Logger();

try{

	// Creating a receiver and intialze it with the incomming data
	$receiver = new SMSReceiver(file_get_contents('php://input'));
	
	//Creating a sender
	$sender = new SMSSender( SERVER_URL, APP_ID, APP_PASSWORD);
	
	$message = $receiver->getMessage(); // Get the message sent to the app
	$address = $receiver->getAddress();	// Get the phone no from which the message was sent 

	$logger->WriteLog($receiver->getAddress());

	list($keyword, $user, $msg) = explode(" ", $message);

error_log('address'.$address);
	if(strtolower($keyword)!=="fz"){
		$response=$sender->sms('Invalid SMS format. Valid format is FZ <UID> <Message>', $address);return;
	}else{
		// $response=$sender->sms('This message isaaa', $address);return;
		
		$msisdn = trim($address, "tel:");
		$r= "SELECT * FROM tbl_subscriber WHERE `msisdn` = $msisdn";
		error_log('qqqq--- '.$r);
		$stmt = $conn->prepare($r);
		try {
			$stmt->execute();
		} catch (PDOException $err) {
			//some logging function
		}
		//loop through each row
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
		error_log(json_encode($rs));

		if (!$rs){$response=$sender->sms('Please subscribe with Friend Zone', $address);return;}
		//TODO user select from friend tbl
		$frs = $rs['id'];
		$q = "SELECT count(*) from tbl_friend WHERE ((frq = $user and frs = $frs) or (frq = $frs and frs = $user))";
		$stmtf = $conn->prepare($q);
		try {
			$stmtf->execute();
		} catch (PDOException $err) {
			//some logging function
		}
		//loop through each row
		$rsf = $stmtf->fetch(PDO::FETCH_ASSOC);
		error_log(json_encode($rsf));
		//if true send sms to user find details from subscriber table
		if(!$rsf){$response=$sender->sms("Invalid friend. User $user not in your friend list.", $address);return;}

		$r= "SELECT * FROM tbl_subscriber WHERE `id` = $user";
		error_log('qqqq--- '.$r);
		$stmt = $conn->prepare($r);
		try {
			$stmt->execute();
		} catch (PDOException $err) {
			//some logging function
		}
		//loop through each row
		$rs = $stmt->fetch(PDO::FETCH_ASSOC);
		
		error_log(json_encode($rs));
		$sender->sms($msg, 'tel:'.$rs['msisdn']);	
	}


	// if ($message=='broadcast') {

	// 	// Send a broadcast message to all the subcribed users
	// 	$response = $sender->broadcast("This is a broadcast message to all the subcribers of the application");
	
	// }else{

	// 	// Send a SMS to a particular user
	// 	$response=$sender->sms('This message is sent only to one user', $address);
	// }

}catch(SMSServiceException $e){
	$logger->WriteLog($e->getErrorCode().' '.$e->getErrorMessage());
}

?>