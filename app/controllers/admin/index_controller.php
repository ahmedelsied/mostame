<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\validator;
use lib\vendor\requests;
use lib\vendor\class_factory;
use lib\vendor\load_component;
use controllers\controller as controller;
class index_controller extends controller
{
    use sessionmanger,helper,token,validator,requests,load_component;
    private $params;
    private $admin;
    private $admin_model;
    public function __construct()
    {
        if($this->current_user() === ADMIN){
            $this->redirect("/admin/dashboard");
        }
    }
    public function default_action()
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.'login');
        $this->loadFooter(ADMIN_TEMP);
    }
    public function login_action()
    {
        $this->post("login");
    }
    private function login($params)
    {
        $this->params = $params;
        $this->is_auth()->is_valid()->is_exist()->log_sessions()->redirect("/admin/dashboard");
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth();
    }
    private function is_valid()
    {
        return (isset($this->params['user_name']) && isset($this->params['password']) && $this->alphanum($this->params['user_name'])) ? $this : $this->not_auth();
    }
    private function is_exist()
    {
        $this->admin_model = class_factory::create_instance("models\admin");
        $password = $this->hash($this->params['password']);
        $this->admin = $this->admin_model->where(["user_name","=",$this->params['user_name']],["password","=",$password])->limit(1)->get()->data[0];
        return !empty($this->admin) ? $this : $this->not_auth();
    }
    private function log_sessions()
    {
        $this->set_session("logged","admin");
        $this->set_session("permission",ADMIN);
        $this->set_session("id",$this->admin['id']);
        $this->set_session("full_name",$this->admin['full_name']);
        $this->set_session("user_name",$this->admin['user_name']);
        return $this;
    }
    private function not_auth()
    {
        $this->redirect_with_message("كلمة السر غير صحيحه !","danger","/admin");
    }
}