<?php
namespace myApp\user;
use MyApp\helpers\connection;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use MyApp\parameters_checker;
class send_closing_message extends parameters_checker
{
    use connection,input_filter;
    private $auth_users = [LISTENER,BOTH];
    private $target_users = [USER,BOTH];
    private $sender;
    private $data;
    private $conversation_model;
    private $sender_id;
    private $user_id;
    private $conversation_id;
    public function __construct($connections,$sender,$data)
    {
        $this->connections = $connections;
        $this->sender = $sender;
        $this->data = $data;
        $this->init();
    }
    private function init()
    {
        $this->security_check()->set_required_data()->set_required_models()->check_if_auth()->send_to_client();
    }
    private function security_check()
    {
        if(!($this->is_sender_have_permission() && $this->parameters_checker(["conversation_id","sender_id"],$this->data))){
            $this->not_auth();
        }
        return $this;
    }
    private function set_required_models()
    {
        $this->conversation_model = class_factory::create_instance("models\conversation");
        $this->user_model = class_factory::create_instance("models\user");
        return $this;
    }
    private function check_if_auth()
    {
        return $this->is_auth() && $this->is_available() ? $this : $this->not_auth();
    }
    private function not_auth()
    {
        $this->unset_connection($this->sender);
        throw new \Exception('sorry not auth');
        return;
    }
    private function is_available()
    {
        return $this->user_model->where(["id","=",$this->sender_id],["banned","=",0])->is_exist();
    }
    private function is_sender_have_permission()
    {
        $this->request = $this->handle_query($this->sender);
        return in_array($this->request['permission'],$this->auth_users);
    }
    private function is_auth()
    {
        $user_id = $this->conversation_model->where(["id","=",$this->conversation_id],["status","=",RUNNING_CHAT])->get("user_id")->pluck("user_id");
        if(!empty($user_id)){
            $this->set_user_id($user_id);
            return true;
        }
        return false;
    }
    private function set_user_id($user_id)
    {
        $this->user_id = $user_id;
    }
    // Need To Refactor
    private function send_to_client()
    {
        for($i=0;$i<count($this->target_users);$i++){
            if(isset($this->connections[$this->target_users[$i]][$this->user_id])) {
                $connection = $this->connections[$this->target_users[$i]][$this->user_id];
                if($this->is_correct_user($connection)) $connection->send(json_encode(array("action"=>"listener_closed_chat","has_arg"=>false)));
                break;
            }
        }
    }

    private function set_required_data()
    {
        $this->sender_id = $this->filter_int($this->data['sender_id']);
        $this->conversation_id = $this->filter_int($this->data['conversation_id']);
        return $this;
    }

    private function is_correct_user($connection)
    {
        $connection_request = $this->handle_query($connection);
        return ($connection_request['page'] == 'chat');
    }
}