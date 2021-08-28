<?php
namespace controllers\errors;
class serverr
{
    public function __construct()
    {
        http_response_code(500);
        echo "server";
        require_once(APP_PATH.'views'.DS.'errors'.DS.'not_found_view.php');
        exit();
    }
}
new serverr;