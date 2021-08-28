<?php
namespace myApp\user;
use MyApp\helpers\connection;
use lib\vendor\input_filter;
use lib\vendor\class_factory;
use MyApp\parameters_checker;
class find_a_listener extends parameters_checker
{
    use connection,input_filter;
    private $auth_users = [USER,BOTH];
    private $sender;
    private $data;
    private $user_model;
    private $user_id;
    public function __construct($connections,$sender,$data)
    {
        $this->connections = $connections;
        $this->sender = $sender;
        $this->data = $data;
        $this->init();
    }
    private function init()
    {
        if(!($this->is_sender_auth() && $this->parameters_checker(["id"],$this->data))){
            $this->unset_connection($this->sender);
            return;
        }

        $this->user_model = class_factory::create_instance("models\user");
        $this->set_user_id();
        if($this->user_is_available()){
            $this->update_user_state();
            $this->send_to_listeners_queue();
        }else{
            $this->sender->send(json_encode(array("action" => "not_available","has_arg" => false)));
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
    private function update_user_state()
    {
        $this->user_model->available = IN_QUEUE;
        $this->user_model->where("id",$this->user_id)->save();
    }

    // Need To Refactor
    private function send_to_listeners_queue()
    {
        // Send Message To Queue Page
        $target = [LISTENER,BOTH];
        for($i=0;$i<2;$i++){
            if(empty($this->connections[$target[$i]])) continue;
            foreach($this->connections[$target[$i]] as $connection){
                if($this->is_correct_target_user($connection)) $connection->send(json_encode(array('action' => "new_user","user_data" => [$this->user_id],"has_arg" => true)));
            }
        }
        $this->sender->send(json_encode(array("action" => "user_in_queue","has_arg" => false)));
    }
    
    private function set_user_id()
    {
        $this->user_id = $this->filter_int($this->data['id']);
    }
    private function is_correct_target_user($connection)
    {
        $connection_request = $this->handle_query($connection);
        return ($connection_request["page"] == "queue" && $connection->resourceId != $this->sender->resourceId);
    }
}