<?php
namespace controllers\user;
use lib\vendor\helper;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\sessionmanger;
use lib\vendor\token;
use lib\vendor\message;
use lib\vendor\requests;
use lib\vendor\class_factory;
use lib\vendor\load_component;
use controllers\controller;
class contact_us_controller extends controller
{
    use helper,validator,input_filter,sessionmanger,token,message,requests,load_component;
    protected $active_page = "contact_us";
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect("/");
        }
        $user = class_factory::create_instance('models\user');

        if($user->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }

        $authorized = $user->is_active($this->get_session("id"));

        if(!$authorized){
            $this->redirect("/user");
        }
    }
    public function default_action()
    {
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->_view(USER_VIEWS.'contact-us');
        $this->loadFooter(USER_TEMP);
    }
    public function contact_us_process_action()
    {
        $this->post("contact_us");
    }
    private function contact_us($params)
    {
        $params_is_ok = $this->params_exist(['hash_token','full_name','subject','email','message'],$params);
        if($params_is_ok && $this->check_token($params)){
            $this->full_name = $this->filter_string($params['full_name']);
            $this->email = $this->filter_string($params['email']);
            $this->subject = $this->filter_string($params['subject']);
            $this->message = $this->filter_string($params['message']);
            $this->validation_logic();
            $new_msg = class_factory::create_instance("models\contact");
            $new_msg->full_name = $this->full_name;
            $new_msg->email = $this->email;
            $new_msg->subject = $this->subject;
            $new_msg->msg = $this->message;
            $new_msg->send_at = date("Y-m-d h:i:s");
            if($new_msg->save()){
                $this->redirect_with_message($this->__("main.contact-us.success"),"success");
            }
        }
    }
    
    private function validation_logic()
    {
        if(!($this->alpha($this->full_name) && $this->email($this->email) && $this->alpha($this->subject))){
            $this->redirect();
        }
        
        if(!$this->min($this->full_name,4)){
            $this->form_errors[] = $this->__("backend_messages.validation.full_name_min_length");
        }elseif(!$this->max($this->full_name,50)){
            $this->form_errors[] = $this->__("backend_messages.validation.full_name_max_length");
        }
        if(!$this->min($this->email,5)){
            $this->form_errors[] = $this->__("backend_messages.validation.email_min_length");
        }elseif(!$this->max($this->email,60)){
            $this->form_errors[] = $this->__("backend_messages.validation.email_max_length");
        }
        if(!$this->min($this->subject,3)){
            $this->form_errors[] = $this->__("backend_messages.validation.subject_min_length");
        }elseif(!$this->max($this->subject,50)){
            $this->form_errors[] = $this->__("backend_messages.validation.subject_max_length");
        }
        if(!empty($this->form_errors)){
            $this->redirect_with_message($this->form_errors,"danger");
        }
    }
}