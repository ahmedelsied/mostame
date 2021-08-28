<?php
namespace lib\vendor;
trait requests
{

    // Handle POST Requests
    public function post($call_back_function)
    {
        (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? (($_SERVER['REQUEST_METHOD'] == 'POST') ? call_user_func_array( "self::$call_back_function", [$_POST] ) : header('location:'.DOMAIN)) : null;
        exit();
    }

    // Handle GET Requests
    public function get($call_back_function)
    {
        (!(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) ? ($_SERVER['REQUEST_METHOD'] == 'GET' ? call_user_func_array( "self::$call_back_function", [$_GET] ) : header('location:'.DOMAIN)) : null;
        exit();
    }

    // Handle Ajax Requests
    public function ajax($call_back_function)
    {
        if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])){
                $arguments = count($_POST) > 0 ? $_POST : $_GET;
                call_user_func_array("self::$call_back_function",[$arguments]);
            }
        }else{
            header('location:'.DOMAIN);
        }
        exit();
    }
}