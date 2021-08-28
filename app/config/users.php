<?php

// Permission
define('ADMIN',0);
define('LISTENER',1);
define('USER',2);
define('BOTH',3);
define("OWNER_ID",1);
// User Gender
define('MALE',0);
define('FEMALE',1);
define('OTHER',2);
$user_gender_arr = ["male"=>MALE,"female"=>FEMALE,"other"=>OTHER];
define("USER_GENDER",$user_gender_arr);

// User Status
define("DISABLE_USER",0);
define("LISTENER_QUESTION",1);
define("ACTIVE_USER",2);

// User From
define("GOOGLE",0);
define("FB",1);

$users_tabels_array = [
    ADMIN       => 'admin',
    LISTENER    => 'user',
    USER        => 'user',
    BOTH        => 'both'
];
$user_permission = [
    LISTENER    => 'مستمع',
    USER        => 'مستخدم عادي',
    BOTH        => 'الصلاحيتين'
];

define('USERS_ARRAY',$users_tabels_array);
define('USERS_PERMISSION',$user_permission);