<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\message;
use lib\vendor\load_component;
use lib\vendor\requests;
use lib\vendor\class_factory;
use controllers\controller as controller;
class archive_controller extends controller
{
    use sessionmanger,helper,message,load_component,requests;
    protected $active_page = "archive";
    private $conversation_model;
    private $chat_id;
    private $my_avatar = "U1";
    private $other_side_avatar  = "U2";
    protected $archived_chat;
    protected $messages;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->conversation_model = class_factory::create_instance("models\conversation");
    }
    public function default_action()
    {
        $this->archived_chat = $this->conversation_model->where("status",DISABLE_CHAT)->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        $this->set_session("load_more",SERVER_LIMIT);
        $this->render_app('archive');
    }
    public function show_action($id)
    {
        $this->active_page = "";
        $this->chat_id = $id[0];
        $this->message_model = class_factory::create_instance("models\message");
        $this->messages = $this->message_model->join("user")->on("user.id","=","message.sender_id")->where("conversation_id",$this->chat_id)->get()->data;
        $this->same_sender_id = !empty($this->messages) ? $this->messages[0]['id'] : null;
        $this->render_app('show_chat_for_admin');
    }
    public function delete_action($id)
    {
        $id = $id[0];
        $this->delete_conversation($id)->redirect_with_message("تم الحذف بنجاح","success","/admin/archive");
    }
    private function delete_conversation($id)
    {
        $this->conversation_model->where("id",$id)->delete();
        return $this;
    }
    public function load_more_action()
    {
        $this->ajax("load_more");
    }
    private function load_more()
    {
        $offset = $this->get_session("load_more");
        $this->archived_chat = $this->conversation_model->where("status",DISABLE_CHAT)->limit(SERVER_LIMIT)->offset($offset)->order_by("id")->order("DESC")->get()->data;
        $new_offset = $this->get_session("load_more")+SERVER_LIMIT;
        $this->set_session("load_more",$new_offset);
        echo json_encode(array("data"=>$this->archived_chat),JSON_UNESCAPED_SLASHES);
    }
    private function is_same_side($msg)
    {
        return $msg['id'] == $this->same_sender_id;
    }
    private function render_app($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
}