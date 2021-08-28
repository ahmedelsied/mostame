<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\validator;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class index_controller extends controller
{
    use sessionmanger,helper,token,requests,validator,load_component;
    protected $active_page = "chat";
    private $messages = "";
    private $my_avatar;
    private $rate;
    protected $is_listener;
    private $other_side_avatar;
    private $parties;
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect(DOMAIN);
        }
        $this->user = class_factory::create_instance('models\user');
        if($this->user->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }
        if($this->user->is_not_active($this->get_session("id"))){
            $this->redirect("/user/active_account");
        }
        // Check If User Have A Listener Questions
        if($this->user->is_have_listener_question($this->get_session("id"))){
            $this->redirect("/user/question");
        }
        $settings = "";
        $this->setting_index = 0;
        if($this->__('settings.align') == "left"){
            $settings = "_ltr";
            $this->setting_index = 1;
        }
        $this->site_settings = class_factory::create_instance("models\site_settings".$settings);
        $this->conversation_model = class_factory::create_instance("models\conversation");
    }
    public function default_action()
    {
        $this->end_of_chat_text = nl2br($this->site_settings->where("id",(END_OF_CHAT_TEXT-$this->setting_index))->get("content")->pluck("content"));
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        if($this->user_has_chat()){
            $count = $this->conversation_model->get_message_count($this->get_session("id"));
            $this->set_session("msg_count",$count);
            $this->my_avatar = chr(rand(65,90));
            $this->other_side_avatar = chr(rand(65,90));
            $this->init_chat();
            $this->_view(USER_VIEWS.'index');
        }else{
            $this->_view(USER_VIEWS.'no_chat');
        }
        $this->loadFooter(USER_TEMP);
    }
    public function load_more_messages_action()
    {
        $this->ajax("load_more_messages");
    }
    private function load_more_messages($params)
    {
        if($this->check_token($params) && isset($params['offset']) && $this->int($params['offset'])){
            $messages = $this->conversation_model->load_more_messages($this->get_session("id"),$params['offset']);
            echo json_encode($messages,JSON_UNESCAPED_SLASHES);
        }
    }
    private function user_has_chat()
    {
        return $this->user->where(["id","=",$this->get_session("id")],["available","=",BUSY])->is_exist();
    }
    private function init_chat()
    {
        $offset = 0;
        $messages = $this->conversation_model->get_conversation_messages($this->get_session("id"),$offset);
        $this->rating = (int) $this->conversation_model->get_rate($this->get_session("id"));
        if(is_array($messages)){
            $this->messages = array_reverse($messages);
            $this->conversation_id = $this->messages[0]["conversation_id"];
        }else{
            $this->conversation_id = $messages;
        }
    }
    protected function is_listener_permission()
    {
        return in_array($this->current_user(),[LISTENER,BOTH]);
    }
    protected function is_listener()
    {
        if(empty($this->is_listener)) $this->is_listener = $this->conversation_model->is_listener($this->get_session("id"));
        return $this->is_listener;
    }
    private function get_rating()
    {
        for($i=1;$i<6;$i++):
            if($this->rating >= $i):
                echo '<i class="fas fa-star"></i>';
            else:
                echo '<i class="far fa-star"></i>';
            endif;
        endfor;
    }
    private function is_message_mine($message)
    {
        return $message["sender_id"] == $this->get_session("id");
    }
    public function close_chat_action()
    {
        $this->post("close_chat");
    }
    private function close_chat($params)
    {
        if($this->check_token($params)){
            $this->conversation_model = class_factory::create_instance("models\conversation");
            $user = $this->is_listener() ? "listener_id" : "user_id";
            $this->parties = $this->conversation_model->where(["$user","=",$this->get_session("id")],["status","=",RUNNING_CHAT])->limit(1)->get("user_id,listener_id")->data[0];
            if(!empty($this->parties)){
                $this->valid_close_chat($params);
                if($this->parties['listener_id'] != $this->get_session("id")){
                    $this->conversation_model->listener_rate = $params['rating'];
                }
                $this->conversation_model->status = DISABLE_CHAT;
                $this->conversation_model->deleted_at = date("Y-m-d h:i:s");
                $this->conversation_model->where($user,$this->get_session("id"))->save();
                $this->user->available = AVAILABLE;
                $this->user->where_in("id",[$this->parties["user_id"],$this->parties["listener_id"]])->save();
            }
        }
        $this->redirect();
    }
    private function valid_close_chat($params)
    {
        if($this->parties['listener_id'] == $this->get_session("id")){
            return;
        }
        if((!isset($params['rating']) || empty($params['rating']))){
            $this->redirect();
        }
        if(!$this->num($params['rating'])){
            $this->redirect();
        }
        if(!$this->max($params['rating'],5)){
            $this->redirect();
        }
        if(!$this->min($params['rating'],1)){
            $this->redirect();
        }
    }
}