<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller;
class join_to_listener_controller extends controller
{
    use sessionmanger,helper,token,requests,validator,input_filter,load_component;
    protected $active_page = "join_to_listener";
    private $question_model;
    private $answer_model;
    protected $question_content;
    protected $answers;
    public function __construct()
    {
        if($this->current_user() != USER){
            $this->redirect(DOMAIN);
        }
        $this->user_model = class_factory::create_instance("models\user");
        if($this->user_model->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }
        $this->question_model = class_factory::create_instance("models\question");
    }
    public function default_action()
    {
        $this->check_for_score();
        $this->set_session("offset",0);
        $this->get_answers($this->get_session("offset"));
        $this->question_content = $this->answers[0]["question_content"];
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->_view(USER_VIEWS.'questions');
        $this->loadFooter(USER_TEMP);
    }
    private function check_for_score()
    {
        if($this->is_set_session("score") && $this->get_session("score") != 0){
            $this->set_session("score",0);
        }
    }
    public function next_question_action()
    {
        $this->ajax("next_question");
    }
    private function next_question($params)
    {
        $this->answer_model = class_factory::create_instance("models\answer");
        try{
            $this->check_next_question_params($params)->calc_score($this->filter_int($params['ans']))->set_new_offset()->get_answers($this->get_session("offset"));
            $this->handle_result();
        }catch(Exception $e){
            echo "error";
        }
    }
    private function handle_result()
    {
        $this->check_if_not_empty_answeres() ? $this->sent_answeres() : $this->sent_score();
    }
    private function check_if_not_empty_answeres()
    {
        return !empty($this->answers);
    }
    private function sent_answeres()
    {
        echo json_encode($this->answers,JSON_UNESCAPED_UNICODE);
    }
    private function sent_score()
    {
        $is_success = (($this->get_session("score")/$this->question_count())*100) >= MIN_SUCCESS_PRECENTAGE;
        if($is_success){
            $this->update_permission();
        }
        echo json_encode(array("score"=>$this->get_session("score")));
    }
    private function check_next_question_params($params)
    {
        return ($this->check_token($params) && $this->valid_next_question_data($params)) ? $this : false;
    }
    private function set_new_offset()
    {
        $this->set_session("offset",$this->get_session("offset")+1);
        return $this;
    }
    private function update_permission()
    {
        $this->user_model = class_factory::create_instance("models\user");
        $this->user_model->type = BOTH;
        $this->set_session("permission",BOTH);
        $this->set_session("type",BOTH);
        $this->user_model->where("id",$this->get_session("id"))->save();
    }
    private function valid_next_question_data($params)
    {
        return (isset($params['ans']) && $this->num($params['ans']));
    }
    private function calc_score($answer)
    {
        if(!$this->is_set_session("score")){
            $this->set_session("score",0);
        }
        $score = $this->answer_model->where(["id","=",$answer],["question_id","=",$this->get_session("curr_question_id")],["is_right","=",1])->is_exist();
        $this->set_session("score",$this->get_session("score")+$score);
        return $this;
    }
    private function get_answers($offset)
    {
        $q_id = $this->question_model->get_current_question_id($offset);
        $this->set_session("curr_question_id",$q_id);
        $this->answers = $this->question_model->left_join("answer")->on("question.id","=","answer.question_id")->where("question.id",$q_id)->get()->data;
    }
    protected function question_count()
    {
        return $this->question_model->row_count();
    }
}