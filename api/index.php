<?php
session_start();
chdir( dirname(__DIR__) );
define("SYS_PATH","lib/");
define("APP_PATH","app/");
define("APP_MODELS","models/");
define("APP_FILES", "src/files/");
define("APP_IMG",   "src/img/");
define("APP_REPORT","src/report/");
require SYS_PATH."main.php";
$app =new Api;
?>