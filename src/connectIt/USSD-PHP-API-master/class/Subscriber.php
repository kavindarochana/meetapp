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

    public function setAge($name, $msisdn, $age, $conn){
        try {
            $sql = "UPDATE `tbl_subscriber` set `age` = '$age' WHERE name = '$name' AND msisdn = '$msisdn'";
            error_log($sql);
            $stmt = $conn->prepare($sql);
            $stmt->execute();
        } catch (Exception $e) {
            error_log(json_emcode($e));
        }
    }




}
