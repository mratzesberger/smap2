<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Get Functions 

// Get User Data by Device
function getUserId($DeviceId){

	// Get Type Id by Name
	$typeResult = mysql_query("SELECT UserId FROM ".TabPrefix.TabUserDevice." WHERE DeviceId = '".$DeviceId."'");
	$User = mysql_fetch_array($typeResult);

	return $User['UserId'];
}
// Get Any Data Single ID Column
function getAnyDataU($TabName, $IdColumn, $IdValue, $UserId){
	$mysqli = dbConnect2();
	$sql = "SELECT * FROM
	        					".TabPrefix.$TabName."
	        					WHERE ".$IdColumn." = '".$IdValue."';";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $result;
}

?>