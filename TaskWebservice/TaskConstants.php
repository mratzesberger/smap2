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
define('TabTask'			, 'Task');
define('TabTaskGroup'		, 'TaskGroup');
define('TabTaskStatus'		, 'TaskStatus');
define('TabProject'			, 'Project');
define('TabProejctResources', 'ProjectResources');
define('TabApplicationLog'	, 'ApplicationLog');
define('TabAddOn'			, 'AddOn');

// Columns
define('ColUserId'			, 'UserId');
define('ColTaskId'			, 'TaskId');
define('ColProjectId'		, 'ProjectId');
define('ColAddOnId'			, 'AddOnId');
define('ColUserChg'			, 'UserChanged');
define('ColUserCre'			, 'UserCreated');
define('ColDateChg'			, 'DateChanged');
define('ColDateCre'			, 'DateCreated');


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


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// Create Functions 


?>