<?php
namespace controllers\main;
use controllers\controller;
use lib\vendor\helper;
use lib\vendor\validator;
use lib\vendor\requests;
use lib\vendor\class_factory;
use lib\vendor\mailer;
use lib\vendor\message;
use lib\vendor\sessionmanger;
use lib\vendor\token;
class forget_password_controller extends controller
{
    use helper,validator,requests,mailer,message,sessionmanger,token;
    protected $active_page = '';
    private $params;
    public function __construct()
    {
        if($this->current_user() != null){
            $this->redirect('/'.$this->get_session('logged'));
        }
    }
    public function default_action()
    {
        $this->set_token();
        $this->loadHeader(MAIN_TEMP);
        $this->renderNav(MAIN_TEMP);
        $this->_view(MAIN_VIEWS.'forget_pass');
        $this->loadFooter(MAIN_TEMP);
    }
    public function forget_pass_action()
    {
        $this->post("forget_pass");
    }
    private function forget_pass($params)
    {
        $this->params = $params;
        $this->is_auth()->is_valid()->generate_new_password()->store_pass()->sent_new_password()->redirect_with_message($this->__("backend_messages.messages.success_reset"),"success","/main/login");
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth();
    }
    private function is_valid(Type $var = null)
    {
        return (isset($this->params['email']) && $this->email($this->params['email']) && $this->is_exist($this->params['email'])) ? $this : $this->connected_to_social();
    }
    private function generate_new_password()
    {
        $this->new_password = $this->generate_random_string(8);
        return $this;
    }
    private function store_pass()
    {
        $this->user->password = $this->hash($this->new_password);
        $this->user->where("email",$this->params['email'])->save();
        return $this;
    }
    private function sent_new_password()
    {
        $this->address($this->params['email']);
        $this->subject($this->__("backend_messages.mail.reset_password_subject"));
        $this->body("<p>");
        $this->body($this->__("backend_messages.mail.reset_password_body"));
        $this->body("<span>".$this->new_password."</span>");
        $this->body("</p>");
        $this->alt_body($this->__("backend_messages.mail.reset_password_body"));
        $this->send_mail();
        return $this;
    }
    private function is_exist()
    {
        $this->user = class_factory::create_instance('models\user');
        return $this->user->where("email",$this->params['email'])->is_null("user_from")->is_exist();
    }
    private function not_auth()
    {
        $this->redirect();
    }
    private function connected_to_social(Type $var = null)
    {
        $this->redirect_with_message($this->__("backend_messages.messages.connected_to_social"),"danger","/main/forget_password");
    }
}