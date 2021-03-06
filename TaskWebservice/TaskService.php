<?php
ob_start();
/* your code here */
$length = ob_get_length();
header('Content-Length: '.$length."\r\n");
header('Accept-Ranges: bytes'."\r\n");
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: X-Requested-With,Content-Type,Accept,Origin');
header('Access-Control-Request-Method: GET,POST,PUT,OPTIONS');
header('Access-Control-Allow-Methods: GET,POST,PUT,OPTIONS');
header('Content-Type: application/jsonp');
// https://af.ssl-secured-server.de/WebContent/service/TaskService.php?method=GetUserData
// http://inpremium.mara-consulting.de/ConfigApp/WebContent/service/Service.php?method=checkLogin&email=mathias.ratzesberger@gmx.de&pass=h4c3pohcd
require_once "RestServer.php";
include "TaskConstants.php";
include "TaskUpdateFunctions.php";
include "TaskGetFunctions.php";
include "TaskInsertFunctions.php";
include "TaskClass.php";
// error_reporting (E_ALL | E_STRICT);
// ini_set ('display_errors' , 1);
$rest = new RestServer();
$rest->addServiceClass('TaskClass');
$rest->handle();

ob_end_flush();
?>