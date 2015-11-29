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
    		$return['UserNick'] = $result['UserNick'];
    		$return['UserName'] = $result['UserName'];
    		$return['UserGUID'] = $result['UserGUID'];
    		$return['DateCreate'] = $result['DateCreate'];
    		$return['DateChange'] = $result['DateChange'];
    		$return['Input'] = $_POST;
    	}else{
    		$return['success'] = "false";
    	}
    	
    	return $return;
    }
    
    public function SetUserData()
    {
    	
      $return = array();
    	$return['success'] = dbConnect();
    	
    	      	if($result){
    		$return['success'] = "true";
      	}else{
    		$return['success'] = "false";
      	}
      	
      	
      $UserId = $_POST['UserId'];
    	$UserName = $_POST['UserName'];
    	$UserNick = $_POST['UserNick'];
    	
    	
    		$sql = "UPDATE
        					".TabPrefix.TabUser."
        					
    				SET
        					UserName = '".$UserName."',
        					UserNick = '".$UserNick."',
        					DateCreate = NOW();
        				
        					
        	 WHERE
                  UserId = '".$UserId."';";
                  
                  $result = mysql_query($sql) OR die(mysql_error());
                  	if($result){
    		$return['success'] = "true";
      	}else{
    		$return['success'] = "false";
      	}
    }
    public function SetUserDataVerbessert()
    {
    	
      	$return = array();
    	$return['success'] = dbConnect();
      	
      	$UserId = $_POST['UserId'];
    	$UserName = $_POST['UserName'];
    	$UserNick = $_POST['UserNick'];
    	
    	
    		$sql = "UPDATE
        					".TabPrefix.TabUser."
        					
    				SET
        					UserName = '".$UserName."',
        					UserNick = '".$UserNick."',
        					DateCreate = NOW()
        	 WHERE
                  UserId = '".$UserId."';";
                  
        $result = mysql_query($sql) OR die(mysql_error());
        $return['sql'] = $sql;
        if($result){
    		$return['success'] = "true";
      	}else{
    		$return['success'] = "false";
      	}
      	return $return;
    }
}
?>
