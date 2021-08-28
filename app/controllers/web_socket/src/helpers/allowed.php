<?php
namespace MyApp\helpers;
use lib\vendor\sessionmanger;
use lib\vendor\token;
trait allowed
{
    use sessionmanger,token;
    private $params;
    private $allowed_params = ["type","hash_token","permission","page"];
    private $allowed_type = ["user","admin"];
    private $allowed_page = ["chat","queue","problems","contact_us","profile"];
    private function is_allowed_request($params)
    {
        $this->set_web_socket_token();
        if($this->check_socket_token($params) && $this->check_params($params)) return true;
        return false;
    }
    private function check_params($params)
    {
        $this->set_params($params);

        if(!($this->is_parameters_is_array() && $this->is_parameters_valid() && $this->is_allowed_type() && $this->is_allowed_permission() && $this->is_allowed_page())) return false;

        return true;
    }
    private function set_params($params)
    {
        $this->params = $params;
    }
    private function is_parameters_is_array()
    {
        return is_array($this->params);
    }
    private function is_parameters_valid()
    {
        return (isset($this->params[$this->allowed_params[0]]) && isset($this->params[$this->allowed_params[1]]) && isset($this->params[$this->allowed_params[2]]) && isset($this->params[$this->allowed_params[3]]));
    }
    private function is_allowed_type()
    {
        return in_array($this->params[$this->allowed_params[0]],$this->allowed_type);
    }
    private function is_allowed_permission()
    {
        return isset(USERS_ARRAY[$this->params[$this->allowed_params[2]]]);
    }
    private function is_allowed_page()
    {
        return in_array($this->params[$this->allowed_params[3]],$this->allowed_page);
    }
}