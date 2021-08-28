<?php
namespace myApp\user;
use MyApp\helpers\connection;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use MyApp\parameters_checker;
class send_message extends parameters_checker
{
    use connection,input_filter;
    private $auth_users = [USER,LISTENER,BOTH];
    private $sender;
    private $data;
    private $conversation_model;
    private $sender_id;
    private $message_content;
    private $conversation_id;
    private $parties;
    public function __construct($connections,$sender,$data)
    {
        $this->connections = $connections;
        $this->sender = $sender;
        $this->data = $data;
        $this->init();
    }
    private function init()
    {
        if(!($this->is_sender_auth() && $this->parameters_checker(["conversation_id","message_content","sender_id"],$this->data))){
            $this->unset_connection($this->sender);
            return;
        }
        $this->conversation_model = class_factory::create_instance("models\conversation");
        $this->user_model = class_factory::create_instance("models\user");
        $this->set_data();
        if($this->is_auth() && $this->is_available()){
            $this->save_message();
            $this->send_to_clients();
        }else{
            $this->sender->send(json_encode(array("action" => "not_authorized_to_send","has_arg" => false)));
            $this->unset_connection($this->sender);
            return;
        }
        return;
    }
    private function is_available()
    {
        return $this->user_model->where(["id","=",$this->sender_id],["banned","=",0])->is_exist();
    }
    private function is_sender_auth()
    {
        $this->request = $this->handle_query($this->sender);
        return in_array($this->request['permission'],$this->auth_users);
    }
    private function is_auth()
    {
        $data = $this->conversation_model->where(["id","=",$this->conversation_id],["status","=",RUNNING_CHAT])->or_where(["listener_id","=",$this->sender_id],["user_id","=",$this->sender_id])->get()->data;
        if(!empty($data)){
            $this->prepare_target_user_id($data);
            return true;
        }
        return false;
    }
    private function prepare_target_user_id($data)
    {
        $this->target_id = [$data[0]["listener_id"],$data[0]["user_id"]];

        // Get Sender Id Index From Array
        $key = array_search($this->request['id'], $this->target_id);

        // Remove Sender Id From array
        unset($this->target_id[$key]);

        $rev = array_reverse($this->target_id);

        $this->target_id = array_pop($rev);
    }
    private function save_message()
    {
        $message = class_factory::create_instance("models\message");
        $message->conversation_id = $this->conversation_id;
        $message->sender_id = $this->sender_id;
        $message->message_content = $this->message_content;
        $message->save();
    }

    // Need To Refactor
    private function send_to_clients()
    {
        for($i=0;$i<count($this->auth_users);$i++){
            if(isset($this->connections[$this->auth_users[$i]][$this->target_id])) {
                $connection = $this->connections[$this->auth_users[$i]][$this->target_id];
                if($this->is_correct_user($connection)) $connection->send(json_encode(array("action"=>"new_message","data"=>[$this->message_content],"has_arg"=>true)));
                break;
            }
        }
        $this->sender->send(json_encode(array("action" => "message_sent","has_arg" => false)));
    }

    private function set_data()
    {
        $this->sender_id = $this->filter_int($this->data['sender_id']);
        $this->conversation_id = $this->filter_int($this->data['conversation_id']);
        $this->message_content = $this->filter_string($this->data['message_content']);
    }

    private function is_correct_user($connection)
    {
        $connection_request = $this->handle_query($connection);
        return ($connection_request['page'] == 'chat');
    }
}