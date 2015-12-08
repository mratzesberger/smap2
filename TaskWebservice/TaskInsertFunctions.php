<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Insert Functions 

// Insert Any Data UserId + Single Column (e.g. UserChanged Columne)
function insertAnyDataU($TabName, $UserId){	
	$mysqli = dbConnect2();
	$sql = "INSERT INTO
	        					".TabPrefix.$TabName."
	    				SET
	        					".ColUserCre." = '".$UserId."',
	        					".ColDateChg." = NOW();";
	
	$result = $mysqli->query($sql);
	$mysqli->close();
	return $mysqli->insert_id;
}

?>