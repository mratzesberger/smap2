<?php

  class UserPost {
    function __construct() {
       
    }

    public function createUserbyFingerprint($fingerprint)
    {
        $return = array();
        $return['success'] = dbConnect();
    	
        
        $sql = "INSERT INTO
                    ".UserTab."
                SET
                    user_id = '',
                    fingerprint = '".$fingerprint."',
                    create_datetime = NOW();";
        $result = mysql_query($sql) OR die(mysql_error());
    
        if($result){
                $return['success'] = "true";
                $return['UserId'] = mysql_insert_id();
        }else{
                $return['success'] = "false";
        }
        return $return;
    }
    public function createUserInviteByEmail()
    {
    	$return = array();
    	$return['success'] = dbConnect();
    	 
    	$JSONdata = array();
    	$JSONdata = $_POST;
    	
    	foreach($JSONdata as $key => $value){
    	
    		switch ($key){
    			case 'ObjectId':
    				$ObjectId = $value;
    				break;
    			case 'UserId':
    				$UserId = $value;
    				break;
    			case 'Email':
    				$Email = $value;
    				break;    
    			case 'Nickname':
    				$Nickname = $value;
    				break;		
    		}
    	}
    	
//     	$sql = "INSERT INTO
//                     ".UserTab."
//                 SET
//                     user_id = '',
//                     email = '".$Email."',
//                     create_datetime = NOW();";
//     	$result = mysql_query($sql) OR die(mysql_error());
    
//     	if($result){
//     		$return['success'] = "true";
//     		$return['UserId'] = mysql_insert_id();
    		
    			// Update Object Property Value
			mysql_query("INSERT INTO ".UserInv."
			(object_id,invited_datetime,name_invite,invited_by_user_id,invite_token)
			VALUES ('$ObjectId',NOW(), '$Nickname', '$UserId', SHA1('$Email'))");
//     	}else{
//     		$return['success'] = "false";
//     	}
		$return['InviteId'] = mysql_insert_id();
		$return['ObjectId'] = $ObjectId;
		$return['UserId'] = $UserId;
		$return['Email'] = $Email;
		$return['Nickname'] = $Nickname;
		
		sendInviteEmail($return['InviteId'], $Email);
    	return $return;
    }
    public function assignUserByToken()
    {
    	$return = array();
    	$return['success'] = dbConnect();
    
    	$JSONdata = array();
    	$JSONdata = $_POST;
    	 
    	foreach($JSONdata as $key => $value){
    		 
    		switch ($key){
    			case 'InviteToken':
    				$InviteToken = $value;
    				break;
    			case 'UserId':
    				$UserId = $value;
    				break;
    		}
    	}

    	InsertUserInviteToken($InviteToken, $UserId);
    	return $return;
    }
    public function SaveName($InviteId, $Name)
    {
    	$return = array();
    	$return['success'] = dbConnect();
    	 
    	InsertUserAppInviteName($InviteId, $Name);
    	return $return;
    }
    public function createUserStatistics($ObjectId, $UserId)
    {
    	InsertUserAppInviteLastVisited($ObjectId, $UserId);
    }
    
  }

?>