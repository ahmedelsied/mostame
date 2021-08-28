<?php
namespace lib\vendor;
trait code_generator{
    private $code;
    private $expire_at;
    protected $code_resend_time;
    private function generate_code()
    {
        $this->load_code_conf();
        $this->code = substr(hash("sha256",uniqid()),0,5);
    }
    private function get_code()
    {
        return $this->code;
    }
    private function expire_at($days)
    {
        $expired = date("Y-m-d") . " + " . $days . " days";
        $this->expire_at = date('Y-m-d', strtotime($expired));
        return $this->expire_at;
    }
    private function set_code_interval()
    {
        if($this->get_session("expire") == null){
            $inactive = 60;
            $expire = time() + $inactive;
            $this->set_session("expire",$expire);
            return true;
        }
        if($this->get_session("expire") - time() <= 0){
            $this->unset_session("expire");
            return true;
        }else{
            return false;
        }
    }
    private function load_code_conf()
    {
        require_once APP_PATH . CONFIG . "code.php";
    }
}