<?php
namespace myApp\user;
use MyApp\helpers\connection;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use MyApp\parameters_checker;
class start_chat extends parameters_checker
{
    use connection,input_filter;
    private $auth_users = [LISTENER,BOTH];
    private $sender;
    private $data;
    private $user_model;
    private $conversation_model;
    private $user_id;
    private $target_user_id;
    public function __construct($connections,$sender,$data)
    {
        $this->connections = $connections;
        $this->sender = $sender;
        $this->data = $data;
        $this->init();
    }
    private function init()
    {
        if(!($this->is_sender_auth() && $this->parameters_checker(["id","target_user_id"],$this->data))){
            $this->unset_connection($this->sender);
            return;
        }

        $this->user_model = class_factory::create_instance("models\user");
        $this->set_user_ids();
        if($this->user_is_available() && $this->target_user_is_in_queue()){
            $this->update_user_state();
            $this->create_conversation();
            $this->send_to_clients();
        }else{
            $this->sender->send(json_encode(array("action" => "already_in_chat","has_arg" => false)));
        }
        return;
    }
    private function is_sender_auth()
    {
        $this->request = $this->handle_query($this->sender);

        return in_array($this->request['permission'],$this->auth_users);
    }
    private function user_is_available()
    {
        return $this->user_model->where(["id","=",$this->user_id],["available","=",AVAILABLE],["banned","=",0])->is_exist();
    }
    private function target_user_is_in_queue()
    {
        return $this->user_model->where(["id","=",$this->target_user_id],["available","=",IN_QUEUE])->is_exist();
    }
    private function update_user_state()
    {
        $this->user_model->available = BUSY;
        $this->user_model->where_in("id",[$this->user_id,$this->target_user_id])->save();
    }
    private function create_conversation()
    {
        $this->conversation_model = class_factory::create_instance("models\conversation");
        $this->conversation_model->user_id = $this->target_user_id;
        $this->conversation_model->listener_id = $this->user_id;
        $this->conversation_model->status = RUNNING_CHAT;
        $this->conversation_model->created_at = date("Y-m-d h:i:s");
        $this->conversation_model->save();
    }

    // Need To Refactor
    private function send_to_clients()
    {
        // Send To Queue Page To Remove Waiting User
        for($i=0;$i<2;$i++){
            if(empty($this->connections[$this->auth_users[$i]])) continue;
            foreach($this->connections[$this->auth_users[$i]] as $connection)
            {
                if($this->is_queue_page($connection)) $connection->send(json_encode(array('action' => "remove_user_from_queue","user_data" => [$this->target_user_id],"has_arg" => true)));
            }
        }

        // Send Message To Rediect User To Chat
        $permissions = [USER,BOTH];
        for($i=0;$i<2;$i++){
            if(isset($this->connections[$permissions[$i]][$this->target_user_id])){
                $connection = $this->connections[$permissions[$i]][$this->target_user_id];
                $connection->send(json_encode(array("action"=>"chat_started","has_arg"=>false)));
            }
        }
        $this->sender->send(json_encode(array("action" => "chat_started","has_arg" => false)));
    }
    
    private function set_user_ids()
    {
        $this->user_id = $this->filter_int($this->data['id']);
        $this->target_user_id = $this->filter_int($this->data['target_user_id']);
    }
    private function is_queue_page($connection)
    {
        $connection_request = $this->handle_query($connection);
        return ($connection_request["page"] == "queue" && $connection->resourceId != $this->sender->resourceId);
    }
}