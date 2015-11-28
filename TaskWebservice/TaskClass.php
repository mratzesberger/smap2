<?php

  class TaskClass {
    function __construct() {
       
    }
    public function GetUserData()
    {
    	$return = array();
    	$return['success'] = dbConnect();
    	 
    	$DeviceId = $_POST['DeviceId'];
    	$DeviceName = $_POST['DeviceName'];
    	$DeviceModel = $_POST['DeviceModel'];
    	$DeviceLocModel = $_POST['DeviceLocModel'];
    	$DeviceSysName = $_POST['DeviceSysName'];
    	$DeviceSysVersion = $_POST['DeviceSysVersion'];
    	
    	$UserId = (int) getUserId($DeviceId);
    	
    	if($UserId){ //Get User
    		$sql = "SELECT
                    *
                		FROM
                    	".TabPrefix.TabUser."
                		WHERE
                    	UserId = '".$UserId."';";
            $result = mysql_query($sql) OR die(mysql_error());	

    	}else{ // Create User
    		$sql = "INSERT INTO
        					".TabPrefix.TabUser."
    				SET
        					UserId = '',
        					DateCreate = NOW();";
        					
        		$result = mysql_query($sql) OR die(mysql_error());	
        		$UserId = mysql_insert_id();									
        	
    		$sqlDevice = "INSERT INTO
        					".TabPrefix.TabUserDevice."
    				SET
        					DeviceId = '".$DeviceId."',
        					UserId = '".$UserId."',
        					DeviceType = '".$DeviceType."',
        					DeviceName = '".$DeviceName."',
        					DeviceModel = '".$DeviceModel."',
        					DeviceLocModel = '".$DeviceLocModel."',
        					DeviceSysName = '".$DeviceSysName."',
        					DeviceSysVersion = '".$DeviceSysVersion."',
        					DateCreate = NOW();";
        		$resultDevice = mysql_query($sqlDevice) OR die(mysql_error());	
    	}
    	
    	
    	if($result){
    		$return['success'] = "true";
    		$return['UserId'] = $UserId;
			$User = mysql_fetch_array($result);
            $return['UserNick'] = $User['UserNick'];
    		$return['UserName'] = $User['UserName'];
    		$return['UserGUID'] = $User['UserGUID'];
    		$return['DateCreate'] = $User['DateCreate'];
    		$return['DateChange'] = $User['DateChange'];
    		//$return['Input'] = $result;
    	}else{
    		$return['success'] = "false";
    	}
    	
    	return $return;
    }
    public function SetUserData()
    {
    	$return = array();
    	$return['success'] = dbConnect();
    	
    	$UserId = (int) $_POST['UserId'];
    	$UserNick = $_POST['UserNick'];
    	$UserName = $_POST['UserName'];
	    $sql = "UPDATE
	        					".TabPrefix.TabUser."
	    				SET
	        					UserNick = '".$UserNick."',
	        					UserName = '".$UserName."',
	        					DateChange = NOW()
	        					WHERE UserId = '".$UserId."';";
	    
	    $result = mysql_query($sql) OR die(mysql_error());	
        if($result){
    		$return['success'] = "true";
    	}else{
    		$return['success'] = "false";
    	}
    	
    	return $return;
    	
    }
    public function SetUserData2()
    {
    	$return = array();
    	
    	$UserId = (int) $_POST['UserId'];
    	$UserNick = $_POST['UserNick'];
    	$UserName = $_POST['UserName'];
		$result = updateUserData($UserId, "UserNick", $UserNick);
		$result = updateUserData($UserId, "UserName", $UserName);
        if($result){
    		$return['success'] = "true";
    	}else{
    		$return['success'] = "false";
    	}
    	
    	return $return;
    	
    }
}
?>