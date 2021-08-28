<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\load_component;
use lib\vendor\requests;
use lib\vendor\input_filter;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\class_factory;
use controllers\controller as controller;
class problem_controller extends controller
{
    use sessionmanger,helper,token,load_component,requests,input_filter,validator,message;
    protected $active_page = "problems";
    protected $problem_content;
    private $problem_model;
    private $problem_content_model;
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect(DOMAIN);
        }
        $this->user_model = class_factory::create_instance('models\user');
        if($this->user_model->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }
        $authorized = $this->user_model->is_active($this->get_session("id"));

        if(!$authorized){
            $this->redirect("/user");
        }
    }
    public function default_action()
    {
        $this->problem_model = class_factory::create_instance('models\problem');
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->have_problem() ? $this->get_problem() : $this->fire_component('no_problems');
        $this->loadFooter(USER_TEMP);
    }
    
    public function new_problem_action()
    {
        $this->post("new_problem");
    }
    
    private function new_problem($params)
    {
        if($this->check_token($params) && $this->valid_new_problem($params)){
            $this->problem_model->user_id = $this->get_session("id");
            $this->problem_model->conversation_id = $params['conversation_id'];
            $this->problem_model->save();
            $prob_id = $this->problem_model->where(["status","=",OPEN],["user_id","=",$this->get_session("id")])->get("id")->pluck("id");
            $this->problem_content_model = class_factory::create_instance("models\problem_content");
            $this->problem_content_model->problem_id = $prob_id;
            $this->problem_content_model->message_content = $params['report_msg'];
            $this->problem_content_model->msg_from = FROM_USER;
            $this->problem_content_model->save();
            $this->redirect("/user/problem");
        }else{
            echo "here";
            $this->redirect();
        }
    }
    private function valid_new_problem($params)
    {
        if(!isset($params['conversation_id']) || empty($params['conversation_id']) || !isset($params['report_msg']) || empty($params['report_msg'])){
            $this->redirect();
        }
        if(!$this->num($params['conversation_id'])){
            $this->redirect();
        }
        $this->conversation_model = class_factory::create_instance("models\conversation");
        if(!$this->conversation_model->where(["status","=",RUNNING_CHAT])->or_where(["listener_id","=",$this->get_session("id")],["user_id","=",$this->get_session("id")])->is_exist()){
            $this->redirect();
        }
        $this->problem_model = class_factory::create_instance("models\problem");
        if($this->problem_model->where(["user_id","=",$this->get_session("id")],["status","=",OPEN])->is_exist()){
            $this->redirect_with_message($this->__("user.problems.close_current_prob"),"danger","/user/index");
        }
        return true;
    }
    public function close_problem_action()
    {
        $this->post("close_problem");
    }
    private function close_problem($params)
    {
        $this->valid_close_request($params);
        $id = $this->filter_string($params['prob_id']);
        $this->problem_model = class_factory::create_instance('models\problem');
        $this->problem_model->status = CLOSED;
        $this->problem_model->where(["id","=",$id],["user_id","=",$this->get_session("id")])->save();
        $this->redirect();
    }
    private function valid_close_request($params)
    {
        if(!isset($params['prob_id']) || empty($params['prob_id']) || !$this->check_token($params)) $this->redirect();
    }
    private function have_problem()
    {
        return $this->problem_model->where(["user_id","=",$this->get_session('id')],["status","=","OPEN"])->is_exist();
    }
    private function get_problem()
    {
        $this->problem_content = $this->problem_model->join("problem_content")->on("problem.id","=","problem_content.problem_id")->where(["problem.user_id","=",$this->get_session('id')],["problem.status","=","OPEN"])->order_by("problem_content.id")->order("DESC")->get()->data;
        $this->_view(USER_VIEWS.'problems');
    }
    public function reply_action()
    {
        $this->post("reply");
    }
    private function reply($params)
    {
        if($this->check_token($params)){
            $this->problem_model = class_factory::create_instance('models\problem');
            $this->problem_id = $this->filter_int($params['prob_id']);
            $this->valid_reply_request($params);
            $this->prob_msg_reply = $this->filter_string($params['prob_msg']);
            $this->problem_content_model = class_factory::create_instance('models\problem_content');
            $this->problem_content_model->problem_id = $this->problem_id;
            $this->problem_content_model->message_content = $this->prob_msg_reply;
            $this->problem_content_model->msg_from = FROM_USER;
            $this->problem_content_model->save();
            $this->redirect("/user/problem");
        }else{
            echo "dsfsdf";
        }
    }
    private function valid_reply_request($params)
    {
        if(!isset($params['prob_id']) || !isset($params['prob_msg']) || empty($params['prob_msg']) || empty($params['prob_id'])){
            $this->redirect();
        }
        if(!$this->problem_model->where(["id","=",$this->problem_id],["user_id","=",$this->get_session("id")])->is_exist()){
            $this->redirect();
        }
    }
    protected function is_from_admin($data)
    {
        return $data == FROM_ADMIN;
    }
}