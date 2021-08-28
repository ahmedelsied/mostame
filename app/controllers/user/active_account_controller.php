<?php
namespace controllers\user;
use lib\vendor\class_factory;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\sessionmanger;
use lib\vendor\validator;
use lib\vendor\load_component;
use lib\vendor\input_filter;
use lib\vendor\mailer;
use controllers\controller;
class active_account_controller extends controller
{
    use helper,token,requests,sessionmanger,validator,load_component,input_filter,mailer;
    protected $active_page = "";
    private $user_model;
    private $code;
    private $form_errors;
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect("/");
        }
        $this->user_model = class_factory::create_instance('models\user');
        
        $authorized = $this->user_model->is_not_active($this->get_session("id"));
        if(!$authorized){
            $this->redirect("/user");
        }
    }
    public function default_action()
    {
        $this->code_resend_time = ($this->get_session("expire") != null && ($this->get_session("expire") - time()) > 0) ? ($this->get_session("expire") - time()) : "";
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->_view(USER_VIEWS.'confirm_code');
        $this->loadFooter(USER_TEMP);
    }
    public function resend_code_action()
    {
        $this->post('resend_code_process');

    }
    public function resend_code_process($params)
    {
        if($this->check_token($params) && $this->set_code_interval()){
            $this->generate_code();

            // Save New Code
            $code = class_factory::create_instance('models\code');
            $code->user_id = $this->get_session("id");
            $code->code = $this->get_code();
            $code->status = ACTIVE;
            $code->expire_at = $this->expire_at(1); // 1 Day
            $code->where("user_id",$code->user_id)->save();

            // Handle Mail Params To Send Activation Code
            $this->address($this->get_session("email"));
            $this->subject($this->__("backend_messages.mail.activation_code"));
            $this->body("<p class='text-".$this->__("settings.align")."'>");
            $this->body($this->get_code() . " ");
            $this->body($this->__("backend_messages.mail.code_message"));
            $this->body("</p>");
            $this->alt_body($this->__("backend_messages.mail.activation_code"));
            $this->send_mail();

            $this->set_code_interval();

            $this->redirect_with_message($this->__("backend_messages.messages.resend_code"),"success",'/user/active_account');
        }else{
            $this->redirect();
        }
    }

    public function active_account_action()
    {
        $this->post('active_account_process');
    }
    private function active_account_process($params)
    {
        $params_is_ok = $this->params_exist(['hash_token','code'],$params);
        if($params_is_ok && $this->check_token($params)){
            $this->code = $params['code'];
            $this->validation_logic();
            $code = class_factory::create_instance('models\code');
            $code->code = $this->code;
            if($code->to_expired_code($this->get_session("id"))){
                $this->user_model->status = $this->get_session("type") == LISTENER ? LISTENER_QUESTION : ACTIVE_USER;
                $this->user_model->where("id",$this->get_session("id"))->save();
                $this->redirect("/user");
            }else{
                $this->redirect();
            }
        }else{
            $this->redirect();
        }
    }
    private function validation_logic()
    {
        if(!($this->alphanum($this->code))){
            $this->redirect();
        }
        if(!$this->max($this->code,5)){
            $this->form_errors[] = $this->__("main.confirm_code.confirm_code_is_wrong");
        }
        if(!empty($this->form_errors)){
            $this->redirect_with_message($this->form_errors,"danger");
        }
    }
}