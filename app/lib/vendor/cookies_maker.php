<?php
namespace lib\vendor;
trait cookies_maker
{
    private $cookie_name;
    private $cookie_value;
    private $cookie_time;
    private $cookie_path;
    private function set_cookie_params($cookie_name,$value,$time,$cookie_path)
    {
        $this->cookie_name = $cookie_name;
        $this->cookie_value = $value;
        $this->cookie_time = $time;
        $this->cookie_path = $cookie_path;
    }
    protected function make_cookie($cookie_name,$value,$time,$path = "/")
    {
        if(is_array($value)) $value = implode(",",$value);
        $this->set_cookie_params($cookie_name,$value,$time,$path);
        setcookie($this->cookie_name, $this->cookie_value, time() + 86400 * $this->cookie_time,$this->cookie_path); // 86400 = 1 day
    }
    protected function delete_cookie($cookie_name)
    {
        if (isset($_COOKIE[$cookie_name])) {
            unset($_COOKIE[$cookie_name]); 
            setcookie($cookie_name, null, -1, '/'); 
            return true;
        } else {
            return false;
        }
    }
    protected function take_a_cookie($cookie_name)
    {
        if(isset($_COOKIE[$cookie_name])){
            if(!empty(strpos($_COOKIE[$cookie_name],","))){
                return explode(",",$_COOKIE[$cookie_name]);
            }
            return $_COOKIE[$cookie_name];
        }
        return null;
    }
    protected function cookie_exist($cookie_name)
    {
        return isset($_COOKIE[$cookie_name]) ? true : false;
    }
    protected function is_cookie_not_empty($cookie_name)
    {
        return (isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) ? true : false;
    }
}