<?php 
// URL
// define('imageURL', 'http://af.mara-consulting.de/WebContent/service/upload/');
define('imageURL', 'https://af.ssl-secured-server.de/WebContent/service/');
// Database
define('dbHost', 'localhost');
define('dbUser', '66625m53712_4');
define('dbPass', 'TjHdtLGP');
define('dbName', '66625m53712_4');

// Tables
define('TabPrefix'			, 'Task_');
define('TabUser'			, 'User');
define('TabUserDevice'		, 'UserDevice');

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
// DB Connect
function dbConnect2(){

	//Connect to DB
	$mysqli = new mysqli(dbHost,dbUser,dbPass,dbName);
	
	return $mysqli;
}
// Get User Data by Device
function getUserId($DeviceId){

	// Get Type Id by Name
	$typeResult = mysql_query("SELECT UserId FROM ".TabPrefix.TabUserDevice." WHERE DeviceId = '".$DeviceId."'");
	$User = mysql_fetch_array($typeResult);

	return $User['UserId'];
}
// Update User Data
function updateUserData($UserId, $DataColumn, $DataValue){
	
	$result = updateAnyData(TabPrefix.TabUser, "UserId", $UserId, $DataColumn, $DataValue);
	return $result;
}
// Update Any Data
function updateAnyData($TabName, $IdColumn, $IdValue, $DataColumn, $DataValue){
	$mysqli = dbConnect2();
	$sql = "UPDATE
	        					".$TabName."
	    				SET
	        					".$DataColumn." = '".$DataValue."',
	        					DateChange = NOW()
	        					WHERE ".$IdColumn." = '".$IdValue."';";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $result;
}
?>