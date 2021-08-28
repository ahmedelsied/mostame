<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\load_component;
use lib\vendor\requests;
use lib\vendor\token;
use lib\vendor\validator;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use controllers\controller as controller;
class questions_controller extends controller
{
    use sessionmanger,helper,requests,token,validator,input_filter,load_component;
    protected $active_page = "questions";
    protected $all_questions;
    protected $question_details;
    private $question_id;
    private $params;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->question_model = class_factory::create_instance("models\question");
    }
    public function default_action()
    {
        $this->all_questions = $this->question_model->get()->data;
        $this->render_page("questions");
    }
    public function add_action()
    {
        $this->render_page("add_questions");
    }
    public function create_action()
    {
        $this->post("create");
    }
    private function create($params)
    {
        $this->set_params($params)->is_auth_to_create()->valid_create_params()->create_new_question()->redirect_with_message("تمت إضافة السؤال بنجاح !","success","/admin/questions/add");
    }
    private function set_params($params)
    {
        $this->params = $params;
        return $this;
    }
    private function is_auth_to_create()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth("هناك شئ ما خطأ يرحى المحاوله في وقت لاحق");
    }
    private function valid_create_params()
    {
        return ($this->valid_answers() && isset($this->params['question_content'])) ? $this : $this->not_auth("من فضلك أدخل البيانات بشكل صحيح");
    }
    private function create_new_question()
    {
        $this->question_model->question_content = $this->filter_string($this->params['question_content']);
        $this->question_model->save();
        $this->question_id = $this->question_model->order_by("id")->order("DESC")->limit(1)->get("id")->pluck("id");
        $this->insert_answers();
        return $this;
    }
    private function insert_answers()
    {
        $answer_model = class_factory::create_instance("models\answer");
        
        $values = substr($this->set_answers(),0,-1);
        $answer_model->execute_multi("INSERT INTO answer (question_id,answer_content,is_right) VALUES $values;");
    }
    private function set_answers()
    {
        $values = '';
        for($i=1;$i<count($this->params);$i++){
            if($i == $this->params['right_answer']){
                $values .= "(";
                $values .= "$this->question_id,'".$this->params['answer_'.$i]."',1"; 
                $values .= "),";
            }elseif(isset($this->params['answer_'.$i])){
                $values .= "(";
                $values .= "$this->question_id,'".$this->params['answer_'.$i]."',0"; 
                $values .= "),";
            }
        }
        return $values;
    }
    private function valid_answers()
    {
        return ((count($this->params) >= 5) && isset($this->params['right_answer']));
    }
    public function delete_action($params)
    {
        $this->question_model->where('id',$params[0])->delete();
        $this->redirect_with_message("تم مسح السؤال بنجاح","success","/admin/questions");
    }
    private function not_auth($message)
    {
        $this->redirect_with_message($message,"danger","/admin/questions/add");
    }
    private function render_page($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
}