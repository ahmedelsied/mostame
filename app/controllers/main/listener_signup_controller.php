<?php
namespace controllers\main;
use controllers\controller;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\sessionmanger;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\mailer;
use lib\vendor\class_factory;
class listener_signup_controller extends controller
{
    use helper,sessionmanger,token,requests,validator,input_filter,mailer;
    protected $active_page = 'listener_signup';
    public function __construct()
    {
        if($this->current_user() != null){
            $this->redirect('/'.$this->get_session('logged'));
        }
    }
    public function default_action()
    {
        $this->loadHeader(MAIN_TEMP);
        $this->renderNav(MAIN_TEMP);
        $this->_view(MAIN_VIEWS.'listener_signup');
        $this->loadFooter(MAIN_TEMP);
    }
    public function listener_signup_process_action()
    {
        $this->post('listener_signup_process_logic');
    }
    private function listener_signup_process_logic($params)
    {
        $params_is_ok = $this->params_exist(['hash_token','full_name','email','pass','cnfrm-pass','birthdate','city','gender'],$params);
        if($params_is_ok && $this->check_token($params)){
            $this->full_name = $this->filter_string($params['full_name']);
            $this->email = $this->filter_string($params['email']);
            $this->pass = $params['pass'];
            $this->is_pass_confirmed = $params['pass'] == $params['cnfrm-pass'] ? true : false ;
            $this->city = $this->filter_string($params['city']);
            $this->birthdate = $params['birthdate'];
            $this->gender = $params['gender'];
            
            $this->form_errors = [];
            $this->new_user = class_factory::create_instance('models\user');

            // Specfic Validation For Signup
            $this->validation_logic();

            $this->new_user->full_name = $this->full_name;
            $this->new_user->email = $this->email;
            $this->new_user->password = $this->hash($params['pass']);
            $this->new_user->city = $this->city;
            $this->new_user->birthdate = $this->birthdate;
            $this->new_user->gender = $this->gender;
            $this->new_user->status = LISTENER_QUESTION;
            $this->new_user->type = LISTENER;
            $this->new_user->joined_at = date("Y-m-d h:i:s");

            if($this->new_user->save()){

                $id = $this->new_user->where("email",$this->email)->get("id")->pluck("id");

                $this->generate_code();

                // Save Code
                $this->new_code = class_factory::create_instance('models\code');
                $this->new_code->user_id = $id;
                $this->new_code->code = $this->get_code();
                $this->new_code->status = ACTIVE;
                $this->new_code->expire_at = $this->expire_at(1); // 1 Day
                $this->new_code->save();

                                
                // Handle Mail Params To Send Activation Code
                $this->address($this->email);
                $this->subject($this->__("backend_messages.mail.activation_code"));
            

                $this->body("<p class='text-".$this->__("settings.align")."'>");
                $this->body($this->get_code() . " ");
                $this->body($this->__("backend_messages.mail.code_message"));
                $this->body("</p>");
                $this->alt_body($this->__("backend_messages.mail.activation_code"));
                $this->send_mail();

                // Set Session For Login
                $this->log_user();
                $this->redirect_with_message($this->__("backend_messages.messages.signup_success"),"success",'/user/active_account');
            
            }
        }else{
            $this->redirect();
        }
    }
    private function validation_logic()
    {
        if(!($this->alpha($this->full_name) && $this->email($this->email) && $this->alpha($this->city) && $this->vdate($this->birthdate))){
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
        
        if(!$this->min($this->pass,8)){
            $this->form_errors[] = $this->__("backend_messages.validation.pass_min_length");
        }elseif(!$this->max($this->pass,40)){
            $this->form_errors[] = $this->__("backend_messages.validation.pass_max_length");
        }
        if(!$this->is_pass_confirmed){
            $this->form_errors[] = $this->__("backend_messages.validation.pass_not_confirmed");
        }
        
        if(!$this->min($this->city,3)){
            $this->form_errors[] = $this->__("backend_messages.validation.city_min_length");
        }elseif(!$this->max($this->city,20)){
            $this->form_errors[] = $this->__("backend_messages.validation.city_max_length");
        }
        if(!in_array($this->gender,[MALE,FEMALE,OTHER])){
            $this->form_errors[] = $this->__("backend_messages.validation.valid_gender");
        }

        $is_email_exist = $this->new_user->where('email',$this->email)->is_exist();

        if($is_email_exist){
            $this->form_errors[] = $this->__("backend_messages.validation.email_exist");
        }
        if(!empty($this->form_errors)){
            $this->redirect_with_message($this->form_errors,"danger");
        }
    }
    public function listener_signup_with_google_action()
    {
        $this->ajax("google_listener_signup");
    }
    private function google_listener_signup($params)
    {
        if(!$this->check_token($params)){
            $this->x_http_msg($this->__("backend_messages.messages.signup_API_error"),"danger");
        }
        $this->new_user = class_factory::create_instance('models\user');
        if($this->new_user->where("email",$params["email"])->is_exist()){
            $this->x_http_msg($this->__("backend_messages.validation.email_exist"),"danger");
        }
        $this->new_user->full_name = (!$this->max($this->full_name,50)) ? substr($params["name"],0,50) : $params["name"];
        $this->new_user->email = (!$this->max($this->email,60)) ? substr($params["email"],0,60) : $params["email"];
        $this->new_user->status = LISTENER_QUESTION;
        $this->new_user->type = LISTENER;
        $this->new_user->user_from = GOOGLE;
        $this->new_user->joined_at = date("Y-m-d h:i:s");
        if($this->new_user->save()) {
            $this->log_user();
            exit();
        }else{
            $this->x_http_msg($this->__("backend_messages.messages.signup_API_error"),"danger");
        }
    }
    public function listener_signup_with_facebook_action()
    {
        $this->ajax("FB_listener_signup");
    }
    private function FB_listener_signup($params)
    {
        if(!$this->check_token($params)){
            $this->x_http_msg($this->__("backend_messages.messages.signup_API_error"),"danger");
        }
        $this->new_user = class_factory::create_instance('models\user');
        if($this->new_user->where("email",$params["email"])->is_exist()){
            $this->x_http_msg($this->__("backend_messages.validation.email_exist"),"danger");
        }
        $this->new_user->full_name = (!$this->max($this->full_name,50)) ? substr($params["name"],0,50) : $params["name"];
        $this->new_user->email = (!$this->max($this->email,60)) ? substr($params["email"],0,60) : $params["email"];
        $this->new_user->gender = isset(USER_GENDER[$params["gender"]]) ? USER_GENDER[$params["gender"]] : OTHER;
        $date = explode("/",$params["birthday"]);
        $this->new_user->birthdate = $date[2] . "-" . $date[0] . "-" . $date[1];
        $this->new_user->city = $params["hometown"]["name"];
        $this->new_user->status = LISTENER_QUESTION;
        $this->new_user->type = LISTENER;
        $this->new_user->user_from = FB;
        $this->new_user->joined_at = date("Y-m-d h:i:s");
        if($this->new_user->save()) {
            $this->log_user();
            exit();
        }else{
            $this->x_http_msg($this->__("backend_messages.messages.signup_API_error"),"danger");
        }
    }
    private function log_user()
    {
        $id = $this->new_user->where("email",$this->new_user->email)->get("id")->pluck("id");
        $this->set_session("permission",LISTENER);
        $this->set_session("logged",USERS_ARRAY[USER]);
        $this->set_session("id",$id);
        $this->set_session("type",LISTENER);
        $this->set_session("full_name",$this->new_user->full_name);
        $this->set_session("email",$this->new_user->email);
    }
}