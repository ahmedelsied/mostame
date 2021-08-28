<?php

isset($_SERVER['SERVER_NAME']) ? define('DOMAIN','https://'.$_SERVER['SERVER_NAME']) : "";

// Default Language
define('DEFAULT_LANG','en');

// Default Timezone
date_default_timezone_set('Africa/Cairo');

// Data Limitation
define("SERVER_LIMIT",5);