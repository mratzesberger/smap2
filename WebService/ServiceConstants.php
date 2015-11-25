<?php 
// URL
// define('imageURL', 'http://af.mara-consulting.de/WebContent/service/upload/');
define('imageURL', 'https://af.ssl-secured-server.de/WebContent/service/');
// Database
define('dbHost', 'localhost');
define('dbUser', '66625m53712_2');
define('dbPass', '4mHF2f4o');
define('dbName', '66625m53712_2');

// Tables
define('AppHier', 'af_d02_application_hier');
define('ObjType', 'af_d02_object_type');
define('TypePrp', 'af_d02_type_properties');
define('ObjProp', 'af_d02_properties');
define('PropVal', 'af_d02_object_property_values');
define('UserApp', 'af_d02_user_applications');
define('UserInv', 'af_d02_user_app_invites');
define('UserTab', 'af_d02_user');

// File Dir
define('UPLOAD_DIR', 'upload/');

// DB Connect
function dbConnect(){

	//Connect to DB
	if (!mysql_connect(dbHost, dbUser, dbPass)) {
		return 'false';
	}else{
		mysql_select_db(dbName);
		return 'true';
	}
}
// Check Type Existence
function CheckTypeExists($TypeName){

	$result = mysql_query("SELECT COUNT(*) FROM ".ObjType." WHERE name = '".$TypeName."'");
	$count = mysql_result($result,0);
	if ($count == 0){
		// Insert New Type
		mysql_query("INSERT INTO ".ObjType."
				(name)
				VALUES ('".$TypeName."')");
	}
}
// Check Property Existence
function CheckPropertyExists($PropertyName){

	$result = mysql_query("SELECT COUNT(*) FROM ".ObjProp." WHERE name = '".$PropertyName."'");
	$count = mysql_result($result,0);
	if ($count == 0){
		// Insert New Type
		mysql_query("INSERT INTO ".ObjProp."
				(name)
				VALUES ('".$PropertyName."')");
	}
}
// Check Property Type Existence
function CheckPropertyTypeExists($TypeId, $PropertyId){

	$result = mysql_query("SELECT COUNT(*) FROM ".TypePrp." WHERE property_id = '".$PropertyId."'
			AND type_id = '".$TypeId."'");
	$count = mysql_result($result,0);
	if ($count == 0){
		// Insert New Type
		mysql_query("INSERT INTO ".TypePrp."
				(property_id, type_id)
				VALUES ('".$PropertyId."', '".$TypeId."')");
	}
}
// Get Type Id by Name
function getTypeId($TypeName){

	CheckTypeExists($TypeName);

	// Get Type Id by Name
	$typeResult = mysql_query("SELECT type_id FROM ".ObjType." WHERE name = '".$TypeName."'");
	$Type = mysql_fetch_array($typeResult);

	return $Type['type_id'];
}
// Get Type Id by Name
function getPropertyIdByName($PropertyName){

	CheckPropertyExists($PropertyName);

	// Get Type Id by Name
	$propResult = mysql_query("SELECT property_id FROM ".ObjProp." WHERE name = '".$PropertyName."'");
	$prop = mysql_fetch_array($propResult);

	return $prop['property_id'];
}
// Get Type Id by Name
function getPropertyId($TypeId, $PropertyName){

	CheckPropertyExists($PropertyName);

	// Get Type Id by Name
	$typeResult = mysql_query("SELECT property_id FROM ".ObjProp." WHERE name = '".$PropertyName."'");
	$Type = mysql_fetch_array($typeResult);

	CheckPropertyTypeExists($TypeId, $Type['property_id']);

	return $Type['property_id'];
}
// Insert / Update Property Value
function InsertObject($ParentId, $TypeId, $UserId){

	// Update Object Property Value
	mysql_query("INSERT INTO ".AppHier."
	(parent_id,type_id,create_user_id,create_datetime)
	VALUES ('$ParentId','$TypeId','".$UserId."',NOW())");
	
	return mysql_insert_id();
}
// Insert / Update Property Value
function InsertPropertyValue($ObjectId, $PropertyId, $Value, $UserId){

	// Update Object Property Value
	mysql_query("INSERT INTO ".PropVal."
	(object_id,property_id,create_user_id, create_datetime, value)
	VALUES ('$ObjectId','$PropertyId','$UserId',NOW(), '$Value')
			ON DUPLICATE KEY UPDATE change_user_id = '$UserId', change_datetime = NOW(), value='$Value'");
	
	return mysql_insert_id();
}
// Insert / Update User App Invite
function InsertUserAppInvite($ObjectId, $UserId){

	// Update Object Property Value
	mysql_query("INSERT INTO ".UserInv."
	(object_id,user_id,invited_datetime)
	VALUES ('$ObjectId','$UserId', NOW())");
	
	return mysql_insert_id();
}
// Insert / Update User App Invite
function InsertUserAppInviteName($InviteId, $Name){

	// Update Object Property Value
	mysql_query("UPDATE ".UserInv." Set Name = '$Name', invite_accepted = '1', last_visited = NOW() WHERE invite_id = '$InviteId'");

}
// Insert / Update User App Invite Token
function InsertUserInviteToken($InviteToken, $UserId){

	// Update Object Property Value
	mysql_query("UPDATE ".UserInv." Set user_id = '$UserId', invite_accepted = '1', last_visited = NOW() WHERE invite_token = '$InviteToken'");

}
// Insert / Update User App Invite Last Visited
function InsertUserAppInviteLastVisited($ObjectId, $UserId){

	// Update Object Property Value
	mysql_query("UPDATE ".UserInv."
	SET last_visited = NOW(), invite_accepted = '1'
	WHERE object_id = '$ObjectId' AND user_id = '$UserId'");
}
// Get User Invite Count by Application
function getUserAppInviteCount($ObjectId){

	$result = mysql_query("SELECT COUNT(*) FROM ".UserInv." WHERE object_id = '".$ObjectId."'
			AND invite_accepted = '1'");
	$count = mysql_result($result,0);

	return $count;
}
// Get User Name Invite By Id
function getUserNameInvite($ObjectId, $UserId){

	$result = mysql_query("SELECT name_invite FROM ".UserInv." WHERE object_id = '".$ObjectId."'
			AND user_id = '$UserId'");
	$Name =  mysql_fetch_array($result);

	return $Name['name_invite'];
}
// Get User Name By Id
function getUserName($ObjectId, $UserId){

	$result = mysql_query("SELECT name FROM ".UserInv." WHERE object_id = '".$ObjectId."'
			AND user_id = '$UserId'");
	$Name =  mysql_fetch_array($result);

	return $Name['name'];
}
// Send Invite EMail
function sendInviteEmail($InviteId, $Email){

	$result = mysql_query("SELECT * FROM ".UserInv." WHERE invite_id = '$InviteId'");
	$Invite =  mysql_fetch_array($result);
	
	$invited_by_name = getUserName($Invite['object_id'], $Invite['invited_by_user_id']);
	$invite_name = $Invite['name_invite'];
	
	$invite_url = "https://af.ssl-secured-server.de/WebContent/index.html?invite_token=".$Invite['invite_token'];
	$receiver = $Email;
	$subject = $invited_by_name.' hat dich zu einem Forum eingeladen';
	$message = "Hallo ".$invite_name.",\ndu wurdest eingeladen an einem Forum teilzunehmen.\n".$invite_url;
	$header = "From: service@anonymusforum.de"."\r\n";
	
	mail($receiver, $subject, $message, $header);
	
}

// Get Sub Item Count
function getSubItemCount($ObjectId, $TypeId){

	$result = mysql_query("SELECT * FROM ".AppHier." WHERE parent_id = '$ObjectId'");
	$count = 0;

	while($row = mysql_fetch_assoc($result)){
		if($row['type_id'] == $TypeId){
			$count++;
		}
		$count = $count + getSubItemCount($row['object_id'], $TypeId);
	}

	return $count;
}

// Get most recent sub item
function getMostRecentItem($ObjectId, $TypeId){

	$result = mysql_query("SELECT * FROM ".AppHier." WHERE parent_id = '$ObjectId'
			AND type_id = '$TypeId'
			ORDER BY create_datetime DESC LIMIT 1");

	$row = mysql_fetch_assoc($result);

	return $row;
}
// Get Application Sub Items by Type
function getAppSubItem($ObjectId, $TypeId) {

	$result = mysql_query("SELECT ".AppHier.".object_id, ".AppHier.".parent_id, ".AppHier.".type_id,
			".AppHier.".create_user_id, ".AppHier.".create_datetime, ".AppHier.".change_user_id, ".AppHier.".change_datetime,
			".ObjType.".name
			FROM ".AppHier." JOIN ".ObjType."
			ON ".ObjType.".type_id = ".AppHier.".type_id
			WHERE ".AppHier.".parent_id = '$ObjectId'
			AND ".ObjType.".type_id = '$TypeId'
			ORDER BY ".AppHier.".create_datetime ASC");

	if (!$result) {
		return false;
		// 			exit;
	}

	$cret = array();
	$counter = 0;

	while($child = mysql_fetch_assoc($result))
	{

		$cret[$counter]['Type'] = $child['name'];
		$cret[$counter]['TypeId'] = $child['type_id'];
		$cret[$counter]['Leaf_ID'] = $child['object_id'];
		$cret[$counter]['CreateUserId'] = $child['create_user_id'];
		$cret[$counter]['CreateDateTime'] = $child['create_datetime'];
		$cret[$counter]['ChangeUserId'] = $child['change_user_id'];
		$cret[$counter]['ChangeDateTime'] = $child['change_datetime'];
		
		$child_id = $child['object_id'];

		$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
				FROM ".PropVal." JOIN ".ObjProp."
				ON ".ObjProp.".property_id = ".PropVal.".property_id
				WHERE ".PropVal.".object_id = $child_id");

		while($prop = mysql_fetch_assoc($result_prop))
		{

			$cret[$counter][$prop['name']] = $prop['value'];

		}

		// Type Conversions
		switch ($cret[$counter]['ValueType']){
			case 'Integer' :
				$cret[$counter]['Value'] = (int) $cret[$counter]['Value'];
				$cret[$counter]['maxValue'] = (int) $cret[$counter]['maxValue'];
				break;
			case 'Boolean' :
				if ($cret[$counter]['Value'] == 'false'){
					$cret[$counter]['Value'] = '';
				}
				$cret[$counter]['Value'] = (bool) $cret[$counter]['Value'];
				break;
			default :
				break;
		}

		$counter++;
			
	}
	mysql_freeresult($result);
	
	return $cret;
}
// Get Application Sub Items by Type
function getAppNewSubItem($ObjectId, $TypeId, $LastObjectId) {

	$result = mysql_query("SELECT ".AppHier.".object_id, ".AppHier.".parent_id, ".AppHier.".type_id,
			".AppHier.".create_user_id, ".AppHier.".create_datetime, ".AppHier.".change_user_id, ".AppHier.".change_datetime,
			".ObjType.".name
			FROM ".AppHier." JOIN ".ObjType."
			ON ".ObjType.".type_id = ".AppHier.".type_id
			WHERE ".AppHier.".parent_id = '$ObjectId'
			AND ".ObjType.".type_id = '$TypeId'
			AND ".AppHier.".object_id > '$LastObjectId'
			ORDER BY ".AppHier.".create_datetime ASC");

	if (!$result) {
		return false;
		// 			exit;
	}

	$cret = array();
	$counter = 0;

	while($child = mysql_fetch_assoc($result))
	{

		$cret[$counter]['Type'] = $child['name'];
		$cret[$counter]['TypeId'] = $child['type_id'];
		$cret[$counter]['Leaf_ID'] = $child['object_id'];
		$cret[$counter]['CreateUserId'] = $child['create_user_id'];
		$cret[$counter]['CreateDateTime'] = $child['create_datetime'];
		$cret[$counter]['ChangeUserId'] = $child['change_user_id'];
		$cret[$counter]['ChangeDateTime'] = $child['change_datetime'];

		$child_id = $child['object_id'];

		$result_prop = mysql_query("SELECT ".ObjProp.".name, ".PropVal.".value
				FROM ".PropVal." JOIN ".ObjProp."
				ON ".ObjProp.".property_id = ".PropVal.".property_id
				WHERE ".PropVal.".object_id = $child_id");

		while($prop = mysql_fetch_assoc($result_prop))
		{

			$cret[$counter][$prop['name']] = $prop['value'];

		}

		// Type Conversions
		switch ($cret[$counter]['ValueType']){
			case 'Integer' :
				$cret[$counter]['Value'] = (int) $cret[$counter]['Value'];
				$cret[$counter]['maxValue'] = (int) $cret[$counter]['maxValue'];
				break;
			case 'Boolean' :
				if ($cret[$counter]['Value'] == 'false'){
					$cret[$counter]['Value'] = '';
				}
				$cret[$counter]['Value'] = (bool) $cret[$counter]['Value'];
				break;
			default :
				break;
		}

		$counter++;
			
	}
	mysql_freeresult($result);

	return $cret;
}
function getAppMembers($ObjectId)
{
	$sql = "SELECT
                    *
                FROM
                    ".UserInv."
                WHERE
                    object_id = '".$ObjectId."';";
	$result = mysql_query($sql) OR die(mysql_error());

	$array = array();
	$counter = 0;

	while($row = mysql_fetch_assoc($result)){
		$array[$counter] = $row;
		$counter++;
	}
	mysql_free_result($result);
	return $array;
}
function convertImageOrientation($jpgFile, $orientation) {
	
	$image   = imagecreatefromjpeg($jpgFile);
	 
	if (!empty($orientation)) {
		switch ($orientation) {
			case 3:
				$image = imagerotate($image, 180, 0);
				break;
				 
			case 6:
				$image = imagerotate($image, -90, 0);
				break;
				 
			case 8:
				$image = imagerotate($image, 90, 0);
				break;
		}
	}
	imagejpeg($image, $image_ret, 90);
	return $image_ret;
}
?>

