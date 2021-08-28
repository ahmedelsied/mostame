<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\load_component;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\message;
use lib\vendor\class_factory;
use controllers\controller as controller;
class problems_controller extends controller
{
    use sessionmanger,helper,load_component,token,requests,message;
    protected $active_page = "problems";
    protected $messages;
    private $problem_model;
    private $params;
    private $prob_id;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->problem_model = class_factory::create_instance("models\problem");
    }
    public function default_action()
    {
        $this->problems = $this->problem_model->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        $this->set_session("load_more",SERVER_LIMIT);
        $this->render_app('problems');
    }
    public function show_action($id)
    {
        $this->set_session("prob_id",$id[0]);
        $this->problem_content_model = class_factory::create_instance("models\problem_content");
        $this->messages = $this->problem_content_model->where("problem_id",$this->get_session("prob_id"))->get()->data;
        $this->render_app("problem_chat");
    }
    public function send_message_action()
    {
        $this->post("send_message");
    }
    public function close_action($id)
    {
        $id = $id[0];
        $this->problem_model->status = CLOSED;
        $this->problem_model->closed_at = date("Y-m-d h:i:s");
        $this->problem_model->where("id",$id)->save();
        $this->redirect();
    }
    public function load_more_action()
    {
        $this->ajax("load_more");
    }
    private function load_more()
    {
        $offset = $this->get_session("load_more");
        $this->archived_chat = $this->problem_model->limit(SERVER_LIMIT)->offset($offset)->order_by("id")->order("DESC")->get()->data;
        $new_offset = $this->get_session("load_more")+SERVER_LIMIT;
        $this->set_session("load_more",$new_offset);
        echo json_encode(array("data"=>$this->archived_chat),JSON_UNESCAPED_SLASHES);
    }
    private function send_message($params)
    {
        $this->prob_id = $this->get_session("prob_id");
        $this->params = $params;
        $this->is_auth()->save_message()->redirect();
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth("لا يمكنك إرسال رساله لهذا البلاغ");
    }
    private function save_message()
    {
        $this->problem_content_model = class_factory::create_instance("models\problem_content");
        $this->problem_content_model->problem_id = $this->prob_id;
        $this->problem_content_model->message_content = $this->params['msg'];
        $this->problem_content_model->msg_from = FROM_ADMIN;
        $this->problem_content_model->save();
        return $this;
    }
    private function render_app($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
    private function not_auth($msg)
    {
        $this->redirect_with_message($msg,"danger","/admin/problem/show/$this->prob_id");
    }
    protected function get_status($status)
    {
        return $status == OPEN ? "مفتوحه" : "مغلقه";
    }
    private function is_same_side($from)
    {
        return $from['msg_from'] == ADMIN;
    }
}