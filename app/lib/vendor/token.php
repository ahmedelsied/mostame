<?php
namespace lib\vendor;
use lib\vendor\sessionmanger;
trait token{
    use sessionmanger;
    private $token;
    private $web_socket_token;
    private $html;
    private function set_token()
    {
        $this->token = $this->generate_toke();
        $this->save_token();
    }
    public function get_token()
    {
        if(!$this->html && empty($this->token)) $this->set_token();
        return $this->get_session('hash_token');
    }
    public function destroy_token()
    {
        $this->token = "";
        $this->unset_session('hash_token');
    }
    public function _token()
    {
        $this->html = true;
        if(empty($this->token)) $this->set_token();
        return "<input type='hidden' name='hash_token' value='".$this->token."'/>";
    }
    public function check_token($params)
    {
        if(!isset($params["hash_token"])) return false;
        return $this->get_session('hash_token') == $params['hash_token'];
    }
    public function set_web_socket_token()
    {
        $time = substr(time(),0,-1);
        $this->web_socket_token = sha1(md5("_hash_token_").$time);
    }
    public function get_web_socket_token()
    {
        if(empty($this->web_socket_token)) $this->set_web_socket_token();
        return $this->web_socket_token;
    }
    public function check_socket_token($params)
    {
        if(!isset($params["hash_token"])) return false;
        return $this->web_socket_token == $params['hash_token'];
    }
    private function save_token()
    {
        $this->set_session('hash_token',$this->token);
    }
    private function generate_toke()
    {
        return hash("sha256",uniqid());
    }
}