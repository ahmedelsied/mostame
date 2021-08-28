<?php
namespace controllers\errors;
class not_found
{
    public function not_found_action()
    {
        http_response_code(404);
        require_once(APP_PATH.'views'.DS.'errors'.DS.'not_found_view.php');
        exit();
    }
}