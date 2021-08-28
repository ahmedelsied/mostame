<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class profile_controller extends controller
{
    use sessionmanger,helper,token,validator,input_filter,requests,load_component;
    protected $active_page = "profile";
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect("/");
        }

        $this->user = class_factory::create_instance('models\user');

        if($this->user->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }
        $authorized = $this->user->is_active($this->get_session("id"));

        if(!$authorized){
            $this->redirect("/user");
        }

        // Check If User From Google Or Facebook
        if($this->user->where_in("user_from",[GOOGLE,FB])->where("id",$this->get_session("id"))->is_exist()){
            $this->redirect("/user");
        }
    }
    public function default_action()
    {
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->_view(USER_VIEWS.'profile');
        $this->loadFooter(USER_TEMP);
    }
    public function update_action()
    {
        $this->post("_update");
    }
    public function _update($params)
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

            // Specfic Validation For Signup
            $this->validation_logic();

            $this->user->full_name = $this->full_name;
            $this->user->email = $this->email;
            if(!empty($this->pass)){
                $this->user->password = $this->hash($params['pass']);
            }
            $this->user->city = $this->city;
            $this->user->birthdate = $this->birthdate;
            $this->user->gender = $this->gender;
            $this->user->type = USER;
            $this->user->joined_at = date("Y-m-d h:i:s");
            if($this->user->where("id",$this->get_session("id"))->save()){
                // Update Sessions For Login
                $this->update_sessions();
                $this->redirect_with_message($this->__("backend_messages.messages.profile_update"),"success",'/user/profile');
            
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
        
        if(!$this->min($this->email,10)){
            $this->form_errors[] = $this->__("backend_messages.validation.email_min_length");
        }elseif(!$this->max($this->email,60)){
            $this->form_errors[] = $this->__("backend_messages.validation.email_max_length");
        }
        
        if($this->req($this->pass) && !$this->min($this->pass,8)){
            $this->form_errors[] = $this->__("backend_messages.validation.pass_min_length");
        }elseif($this->req($this->pass) && !$this->max($this->pass,40)){
            $this->form_errors[] = $this->__("backend_messages.validation.pass_max_length");
        }

        if($this->req($this->pass) && !$this->is_pass_confirmed){
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

        if(!empty($this->form_errors)){
            $this->redirect_with_message($this->form_errors,"danger");
        }
    }
    private function update_sessions()
    {
        $this->set_session("full_name",$this->user->full_name);
        $this->set_session("email",$this->user->email);
        $this->set_session("password",$this->user->password);
        $this->set_session("city",$this->user->city);
        $this->set_session("birthdate",$this->user->birthdate);
        $this->set_session("gender",$this->user->gender);
    }
}