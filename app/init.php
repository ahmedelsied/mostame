<?php
use lib\vendor\sessionmanger;

header('X-Frame-Options: DENY');
define("HARD_HASH",sha1("this_hard_hash"));

// REQUIRE CONFIG FILES
require_once 'config'.DS.'paths.php';
require_once CONFIG.'server.php';
require_once CONFIG.'db.php';
require_once CONFIG.'users.php';
require_once CONFIG.'chat.php';
require_once CONFIG.'controllers_paths.php';
require_once CONFIG.'views_paths.php';
require_once CONFIG.'lib_paths.php';
require_once CONFIG.'temp_paths.php';
require_once CONFIG.'question.php';
require_once CONFIG.'front_paths.php';
require_once CONFIG.'site_settings.php';
require_once CONFIG.'problems.php';


require_once VENDOR.'autoloader.php';
sessionmanger::start();