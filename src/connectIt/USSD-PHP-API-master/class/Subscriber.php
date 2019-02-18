<?php

class Subscriber
{


   //add user
    public function setUser($name, $msisdn, $conn)
    {
        error_log('set user');
        try {
            $sql = "INSERT INTO `tbl_subscriber` (`name`, `msisdn`) VALUES 
					('" . $name . "', '" . $msisdn . "')";

            error_log($sql);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            error_log(json_encode($e));
        }
		
				//$quy_sessions=mysql_query($sql_sessions);
    }

    public function setAge($name, $msisdn, $age, $conn)
    {
        try {
            $sql = "UPDATE `tbl_subscriber` set `age` = '$age' WHERE name = '$name' AND msisdn = '$msisdn'";
            error_log($sql);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            error_log(json_emcode($e));
        }
    }

    public function getSubscriber($msisdn, $conn)
    {
        $sql_session = "SELECT *  FROM  `tbl_subscriber` WHERE  msisdn='" . $msisdn . "'";
		// $quy_sessions=mysqli_query($sql_session);
		// $fet_sessions=mysqli_fetch_array($quy_sessions);
		// $this->session_others=$fet_sessions['others'];
		// return $fet_sessions;	


        $stmt = $conn->prepare($sql_session);
        try {
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
			//select column by key and use
            return $result;

        } catch (PDOException $err) {
            error_log(json_encode($err));
        }
		//loop through each row

    }




}
