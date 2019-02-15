<?php

class Operations
{

	public $session_id = '';
	public $session_menu = '';
	public $session_pg = 0;
	public $session_tel = '';
	public $session_others = '';

	public function setSessions($sessions, $conn)
	{
		error_log('set session');

		try {
			$sql_sessions = "INSERT INTO `sessions` (`sessionsid`, `tel`, `menu`, `pg`, `others`) VALUES 
			('" . $sessions['sessionid'] . "', '" . $sessions['tel'] . "', '" . $sessions['menu'] . "', '" . $sessions['pg'] . "', '" . $sessions['others'] . "')";


			$stmt = $conn->prepare($sql_sessions);
			$stmt->execute();
		} catch (Exception $e) {
			error_log(json_encode($e));
		}

		//$quy_sessions=mysql_query($sql_sessions);
	}

	public function getSession($sessionid, $conn)
	{

		$sql_session = "SELECT *  FROM  `sessions` WHERE  sessionsid='" . $sessionid . "'";
		// $quy_sessions=mysqli_query($sql_session);
		// $fet_sessions=mysqli_fetch_array($quy_sessions);
		// $this->session_others=$fet_sessions['others'];
		// return $fet_sessions;	


		$stmt = $conn->prepare($sql_session);
		try {
			$stmt->execute();
		} catch (PDOException $err) {
			//some logging function
		}
		//loop through each row
		$result = $stmt->fetch(PDO::FETCH_ASSOC);
			//select column by key and use
		$this->session_others = ($result['menu']);



		return $result;

	}


	public function saveSesssion($conn)
	{
		$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $this->session_menu . "',
									`pg` =  '" . $this->session_pg . "',
									`others` =  '" . $this->session_others . "'
									WHERE `sessionsid` =  '" . $this->session_id . "'";
		// $quy_sessions=mysql_query($sql_session);

		$quy_sessions = $conn->prepare($sql_session);

		// execute the query
		$quy_sessions->execute();
	}


	//add user
	public function setName($name, $conn)
	{
		error_log('set user');

		try {
			$sql_sessions = "INSERT INTO `tbl_subscriber` (`name`) VALUES 
					('" . $name . "')";


			$stmt = $conn->prepare($sql_sessions);
			$stmt->execute();
		} catch (Exception $e) {
			error_log(json_encode($e));
		}
		
				//$quy_sessions=mysql_query($sql_sessions);
	}



}

?>