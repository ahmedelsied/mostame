<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\message;
use lib\vendor\requests;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class profile_settings_controller extends controller
{
    use sessionmanger,helper,token,message,requests,validator,input_filter,load_component;
    protected $active_page = "profile_settings";
    private $admin_model;
    private $params;
    private $new_password;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
    }
    public function default_action()
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.'profile_settings');
        $this->loadFooter(ADMIN_TEMP);
    }
    public function edit_action()
    {
        $this->post("update");
    }
    private function update($params)
    {
        $this->admin_model = class_factory::create_instance("models\admin");
        $this->set_params($params)->is_auth()->is_valid_params()->is_there_a_password()->save_data()->log_new_sessions()->redirect_with_message("تم تحديث بياناتك الشخصيه","success","/admin/profile_settings");
    }
    private function set_params($params)
    {
        $this->params = $params;
        return $this;
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth();
    }
    private function is_valid_params()
    {
        return ($this->alpha($this->params['full_name']) && $this->alpha($this->params['user_name'])) ? $this : $this->not_valid();
    }
    private function is_there_a_password()
    {
        $this->is_set_new_password();
        return $this;
    }
    private function save_data()
    {
        $this->admin_model->user_name = $this->filter_string($this->params["user_name"]);
        $this->admin_model->full_name = $this->filter_string($this->params["full_name"]);
        if(!empty($this->new_password)) $this->admin_model->password = $this->new_password;
        $this->admin_model->user_name = $this->filter_string($this->params["user_name"]);
        $this->admin_model->where("id",$this->get_session("id"))->save();
        return $this;
    }
    private function log_new_sessions()
    {
        $this->set_session("user_name",$this->params["user_name"]);
        $this->set_session("full_name",$this->params["full_name"]);
        return $this;
    }
    private function is_set_new_password()
    {
        isset($this->params['old_password']) && (!empty($this->params['old_password'])) && isset($this->params['new_password']) && isset($this->params['cnfrm_new_password']) ? $this->valid_new_password() : null;
    }
    private function valid_new_password(Type $var = null)
    {
        $old_password = $this->admin_model->where("id",$this->get_session("id"))->get("password")->pluck("password");
        ($old_password == $this->hash($this->params['old_password'])) && !empty($this->params['new_password']) && !empty($this->params['cnfrm_new_password']) && ($this->params['new_password'] == $this->params['cnfrm_new_password']) ? $this->set_new_password() : $this->password_error();
    }
    private function set_new_password()
    {
        $this->new_password = $this->hash($this->params['new_password']);
    }
    private function password_error()
    {
        $this->redirect_with_message("يبدو أن هناك خطأ ما بتغيير كلمة السر","danger","/admin/profile_settings");
    }
    private function not_valid()
    {
        $this->redirect_with_message("من فضلك قم بكتابة البيانات بشكل صحيح","danger","/admin/profile_settings");
    }
    private function not_auth()
    {
        $this->finish_session();
        $this->redirect("/");
    }
}