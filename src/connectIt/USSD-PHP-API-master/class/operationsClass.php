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


	public function saveSesssion($conn, $type = null, $data = null)
	{
		$sqlU = null;
		error_log('type---' . $type);
		switch ($type) {

			case (null):
				$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $this->session_menu . "',
									`pg` =  '" . $this->session_pg . "',
									`others` =  '" . $this->session_others . "',
									`msisdn` =  '" . $data . "'
									WHERE `sessionsid` =  '" . $this->session_id . "'";
				break;

			case ('name'):
				$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $this->session_menu . "',
									`pg` =  '" . $this->session_pg . "',
									`name` =  '" . $data . "',
									`others` =  '" . $this->session_others . "'
									WHERE `sessionsid` =  '" . $this->session_id . "'";
				break;

			case ('age'):
				$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $this->session_menu . "',
									`pg` =  '" . $this->session_pg . "',
									`age` =  '" . $data . "',
									`others` =  '" . $this->session_others . "'
									WHERE `sessionsid` =  '" . $this->session_id . "'";
				break;

			case ('sex'):
				$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $this->session_menu . "',
									`pg` =  '" . $this->session_pg . "',
									`sex` =  '" . $data . "',
									`others` =  '" . $this->session_others . "'
									WHERE `sessionsid` =  '" . $this->session_id . "'";

				$sqlU = 'INSERT INTO `tbl_subscriber` (`name`, `sex`, `age`, `msisdn`)
				SELECT `name`, `sex`, `age`, `msisdn`  FROM `sessions` WHERE `sessionsid` = "' . $this->session_id . '"';

				break;

			case ('menu'):
				$sql_session = "UPDATE  `sessions` SET 
									`menu` =  '" . $data . "' 
									WHERE `sessionsid` =  '" . $this->session_id . "'";
				break;
			case ('gender'):
				$sql_session = "UPDATE  `sessions` SET 
									`sex` =  '" . $data . "' 
									WHERE `sessionsid` =  '" . $this->session_id . "'";
				break;
		}

		error_log('update---' . $sql_session);
		$quy_sessions = $conn->prepare($sql_session);

		// execute the query
		$quy_sessions->execute();

		if ($sqlU) {
			$conn->prepare($sqlU)->execute();
			error_log('sql U ----' . $sqlU);
			//TODO::Subscription API
		}
	}


	public function getFriends($conn, $page=1, $uid = null, $age = null, $frq = null, $request = null) {

		// $sql = 'SELECT * FROM `tbl_subscriber`';

		// $redis = new Redis();
		// $redis->connect("127.0.0.1", 6379);
 
		// if ($redis->get($uid.'list')) {
			$sql = "SELECT * FROM `tbl_subscriber` WHERE id != $uid AND id NOT in (SELECT frq FROM tbl_friends where frq = $uid) AND 
					id not in (SELECT frs FROM tbl_friends where frs = $uid) order by create_ts DESC LIMIT 15";

			error_log('fselect----'.$sql);
			$sql_prepare = $conn->prepare($sql);
			$result = $conn -> query($sql);
			while ($user = $result->fetch(PDO::FETCH_ASSOC)) {
				$i[] = ['id' => $user['id'] , 'name' => explode(' ',trim($user['name']))[0]];
			}

			// if ($redis && !$request) {
			// 	$redis->setex($uid.'list', 30, json_encode($i));
				
			// }
		// } else {
		// 	$i = $redis->get($uid.'list');
		// 	$i = json_decode($i);
		// 	error_log('ulist' . json_encode($i));
		// }
		
		if ($request) {
			$frs = $i[$frq]['id'];
			$q = "INSERT INTO `tbl_friends`(`frq`, `frs`) VALUES ($uid, $frs)";
			$sql_prepare = $conn->prepare($q);
			if ($q->execute()) {
				return 'Your friend request sent to '. $i['name'];
			} else {
				return 'Your friend request can not be process right now. Pleae try again later ';
			}
		}  


		if ($page == 1) {
			return 'Select a friend from below list

1. '.@$i[0]['name'].'
2. '.@$i[1]['name'].'
3. '.@$i[2]['name'].'
4. '.@$i[3]['name'].'
5. '.@$i[4]['name'].'

92.Next';
		} else if ($page == 2) {
			return 'Select a friend from below list
	
6. '.@$i[5]['name'].'
7. '.@$i[6]['name'].'
8. '.@$i[7]['name'].'
9. '.@$i[8]['name'].'
10. '.@$i[9]['name'].'
			
92.Next
93.Back';
		} else {
			return 'Select a friend from below list
	
11. '.@$i[10]['name'].'
12. '.@$i[11]['name'].'
13. '.@$i[12]['name'].'
14. '.@$i[13]['name'].'
15. '.@$i[14]['name'].'
			
			93.Back';
		}
	}


}

?>