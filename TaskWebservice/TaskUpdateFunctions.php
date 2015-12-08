<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Update Functions 

// Update User Data
function updateUserData($UserId, $DataColumn, $DataValue){
	
	$result = updateAnyData(TabUser, "UserId", $UserId, $DataColumn, $DataValue);
	return $result;
}
// Update Task Data
function updateTaskData($TaskId, $UserId, $DataColumn, $DataValue){
	
	$result = updateAnyDataU(TabTask, ColTaskId, $TaskId, $UserId, $DataColumn, $DataValue);
}
// Update Any Data Single Column (No UserChanged Column)
function updateAnyData($TabName, $IdColumn, $IdValue, $DataColumn, $DataValue){
	$mysqli = dbConnect2();
	$sql = "UPDATE
	        					".TabPrefix.$TabName."
	    				SET
	        					".$DataColumn." = '".$DataValue."',
	        					".ColDateChg." = NOW()
	        					WHERE ".$IdColumn." = '".$IdValue."';";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $result;
}
// Update Any Data UserId + Single Column (e.g. UserChanged Columne)
function updateAnyDataU($TabName, $IdColumn, $IdValue, $UserId, $DataColumn, $DataValue){
	$mysqli = dbConnect2();
	$sql = "UPDATE
	        					".TabPrefix.$TabName."
	    				SET
	        					".$DataColumn." = '".$DataValue."',
	        					".ColUserChg." = '".$UserId."',
	        					".ColDateChg." = NOW()
	        					WHERE ".$IdColumn." = '".$IdValue."';";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $result;
}

// Update Any Data All Fields (dynamic Set and Where String)
function updateAnyDataAll($TabName, $SetString, $WhereString){
	$mysqli = dbConnect2();
	$sql = "UPDATE
	        					".TabPrefix.$TabName."
	    				SET
	        					".$SetString.",
	        					".ColDateChg." = NOW()
	        					WHERE ".$WhereString.";";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $result;
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>