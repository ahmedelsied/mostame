<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\mailer;
use lib\vendor\class_factory;
use controllers\controller as controller;
class messages_controller extends controller
{
    use sessionmanger,helper,token,requests,mailer;
    protected $active_page = "messages";
    private $message_model;
    private $params;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->message_model = class_factory::create_instance("models\contact");
    }
    public function default_action()
    {
        $this->messages = $this->message_model->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        $this->set_session("load_more",SERVER_LIMIT);
        $this->render_app('messages');
    }
    public function reply_action()
    {
        $this->post("reply");
    }
    private function reply($params)
    {
        $this->set_params($params)->is_auth()->send_message()->update_message_reply_status()->redirect_with_message("تم الإرسال بنجاح","success","/admin/messages");
    }
    private function set_params($params)
    {
        $this->params = $params;
        return $this;
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_atuh("هناك شئ ما خطأ");
    }
    private function send_message()
    {
        $this->address($this->params['email']);
        $this->subject($this->params['subject']);
        $this->body("<p>");
        $this->body("<span>".$this->params['msg']."</span>");
        $this->body("</p>");
        $this->alt_body($this->params['msg']);
        return  $this->send_mail() ? $this : $this->not_atuh("هناك شئ ما خطأ");
    }
    private function update_message_reply_status()
    {
        $this->message_model->is_reply = true;
        $this->message_model->where("id",$this->params['msg_id'])->save();
        return $this;
    }
    public function load_more_action()
    {
        $this->ajax("load_more");
    }
    private function load_more()
    {
        $offset = $this->get_session("load_more");
        $this->messages = $this->message_model->limit(SERVER_LIMIT)->offset($offset)->order_by("id")->order("DESC")->get()->data;
        $new_offset = $this->get_session("load_more")+SERVER_LIMIT;
        $this->set_session("load_more",$new_offset);
        echo json_encode(array("data"=>$this->messages),JSON_UNESCAPED_SLASHES);
    }
    public function delete_action($id)
    {
        $id = $id[0];
        $this->message_model->where("id",$id)->delete();
        $this->redirect_with_message("تم الحذف بنجاح","success","/admin/messages");
    }
    protected function is_reply($msg)
    {
        return $msg['is_reply'] ? "style='background:white'" : "style='background:#ececec'";
    }
    private function not_atuh($msg)
    {
        $this->redirect_with_message($msg,"danger","/admin/messages");
    }
    private function render_app($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
}