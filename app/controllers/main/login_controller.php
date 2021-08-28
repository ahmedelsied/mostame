<?php
namespace controllers\main;
use controllers\controller;
use lib\vendor\helper;
use lib\vendor\sessionmanger;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
class login_controller extends controller
{
    use helper,sessionmanger,token,requests,validator,input_filter;
    protected $active_page = 'login';
    private $user_model;
    private $user;
    public function __construct()
    {
        // Check If There Is No Current User
        if($this->current_user() != null){
            $this->redirect('/'.$this->get_session('logged'));
        }
    }
    public function default_action()
    {
        $this->loadHeader(MAIN_TEMP);
        $this->renderNav(MAIN_TEMP);
        $this->_view(MAIN_VIEWS.'login');
        $this->loadFooter(MAIN_TEMP);
    }
    public function login_process_action()
    {
        $this->post('login_process_logic');
    }
    private function login_process_logic($params)
    {
        $params_is_ok = $this->params_exist(['hash_token','email','pass'],$params);
        if($params_is_ok && $this->check_token($params)){

            $email = $this->filter_string($params['email']);
            $pass = $this->hash($params['pass']);

            // Validation
            if(!($this->email($email))){
                $this->redirect_with_message($this->__("main.login.valid_mail"),"danger");
            }

            $this->user_model = class_factory::create_instance('models\user');
            $this->user = $this->user_model->where(["email","=",$email],["password","=",$pass],["banned","!=",true])->get("id,full_name,email,password,city,gender,birthdate,type");
            if(!empty($this->user->data)){
                $this->set_session('id',$this->user->pluck("id"));
                $this->set_session('permission',$this->user->pluck("type"));
                $this->set_session('logged',USERS_ARRAY[USER]);
                $this->set_session('type',$this->user->pluck("type"));
                $this->set_session("full_name",$this->user->pluck("full_name"));
                $this->set_session("email",$this->user->pluck("email"));
                $this->set_session("password",$this->user->pluck("password"));
                $this->set_session("city",$this->user->pluck("city"));
                $this->set_session("birthdate",$this->user->pluck("birthdate"));
                $this->set_session("gender",$this->user->pluck("gender"));
                $this->redirect("/".USERS_ARRAY[USER]);
            }else{
                $this->redirect_with_message($this->__("main.login.failed_login"),"danger");
            }
        }else{
            $this->redirect();
        }
    }
    public function login_with_facebook_action()
    {
        $this->ajax("FB");
    }
    private function FB($params)
    {
        if(!$this->check_token($params)){
            $this->x_http_msg($this->__("backend_messages.messages.login_API_error"),"danger");
        }
        $this->user_model = class_factory::create_instance('models\user');
        $this->user = $this->user_model->where(["email","=" ,$params["email"]],["user_from","=",FB],["status","!=",DISABLE_USER])->get("id,full_name,email,type");
        if(empty($this->user->data)){
            $this->x_http_msg($this->__("backend_messages.messages.login_API_error"),"danger");
        }
        $this->log_user();
        $this->x_http_msg($this->__("backend_messages.messages.login_API_success"),"success");
    }
    
    public function login_with_google_action()
    {
        $this->ajax("google");
    }
    private function google($params)
    {
        if(!$this->check_token($params)){
            $this->x_http_msg($this->__("backend_messages.messages.login_API_error"),"danger");
        }
        $this->user_model = class_factory::create_instance('models\user');
        $this->user = $this->user_model->where(["email","=" ,$params["email"]],["user_from","=",GOOGLE],["status","!=",DISABLE_USER])->get("id,full_name,email,type");
        if(empty($this->user->data)){
            $this->x_http_msg($this->__("backend_messages.messages.login_API_error"),"danger");
        }
        $this->log_user();
        $this->x_http_msg($this->__("backend_messages.messages.login_API_success"),"success");
    }
    private function log_user()
    {
        $this->set_session('permission',$this->user->pluck("type"));
        $this->set_session('logged',USERS_ARRAY[USER]);
        $this->set_session('id',$this->user->pluck("id"));
        $this->set_session('type',$this->user->pluck("type"));
        $this->set_session('full_name',$this->user->pluck("full_name"));
        $this->set_session('email',$this->user->pluck("email"));
    }
}