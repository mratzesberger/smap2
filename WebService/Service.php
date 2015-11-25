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
// http://inpremium.mara-consulting.de/ConfigApp/Service/Service.php?method=getSubItems&objectId=1
// http://inpremium.mara-consulting.de/ConfigApp/WebContent/service/Service.php?method=checkLogin&email=mathias.ratzesberger@gmx.de&pass=h4c3pohcd
require_once "RestServer.php";
include "ServiceConstants.php";
include "AppGetService.php";
include "AppPostService.php";
include "UserGetService.php";
include "UserPostService.php";
include "UploadPostService.php";
// error_reporting (E_ALL | E_STRICT);
// ini_set ('display_errors' , 1);
$rest = new RestServer();
$rest->addServiceClass('AppGet');
$rest->addServiceClass('AppPost');
$rest->addServiceClass('UserGet');
$rest->addServiceClass('UserPost');
$rest->addServiceClass('UploadPost');
$rest->handle();

ob_end_flush();
?>