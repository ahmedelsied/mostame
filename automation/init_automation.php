<?php
(!defined('DS')) ? define('DS', DIRECTORY_SEPARATOR) : null;
define("OUT_AUTO","..".DS."app".DS);
define("CONFIG_AUTO",OUT_AUTO.'config'.DS);
require_once CONFIG_AUTO.'paths.php';
require_once CONFIG_AUTO.'db.php';
require_once CONFIG_AUTO.'lib_paths.php';
require_once OUT_AUTO.VENDOR.'autoloader.php';
$connect = new lib\database\db_connection;