<?php
namespace models;
class conversation extends model
{
    protected static $table_name = 'conversation';
    public static $table_schema = array(
        'id'            => '',
        'user_id'       => '',
        'listener_id'   => '',
        'status'        => '',
        'listener_rate' => '',
        'created_at'    => '',
        'deleted_at'    => ''
    );
    protected static $primary_key = 'id';

    public function __set($prop,$value)
    {
        self::$table_schema[$prop] = $value;
    }
    public function __get($prop)
    {
        return self::$table_schema[$prop];
    }
    public function get_conversation_messages($user_id,$start)
    {
        $data = $this->join("message")->on("message.conversation_id","=","conversation.id")->where(["conversation.status","=",RUNNING_CHAT])->or_where(["listener_id","=",$user_id],["user_id","=",$user_id])->order_by("message.id")->order("DESC")->limit(SERVER_LIMIT)->get()->data;
        if(empty($data)){
            $data = $this->where(["conversation.status","=",RUNNING_CHAT])->or_where(["listener_id","=",$user_id],["user_id","=",$user_id])->get('id')->pluck("id");
            return $data;
        }
        return $data;
    }
    public function load_more_messages($user_id,$start)
    {
        $data = $this->join("message")->on("message.conversation_id","=","conversation.id")->where(["conversation.status","=",RUNNING_CHAT])->or_where(["listener_id","=",$user_id],["user_id","=",$user_id])->order_by("message.id")->order("DESC")->limit(SERVER_LIMIT)->offset($start)->get()->data;
        print_r($data);
        exit();
        return $this->join("message")->on("message.conversation_id","=","conversation.id")->where(["conversation.status","=",RUNNING_CHAT])->or_where(["listener_id","=",$user_id],["user_id","=",$user_id])->order_by("message.id")->order("DESC")->limit(SERVER_LIMIT)->offset($start)->get()->data;
    }
    public function get_rate($user_id)
    {
        return $this->or_where(["listener_id","=",$user_id],["user_id","=",$user_id])->get('AVG(listener_rate) as rating')->pluck('rating');
    }
    public function get_message_count($id)
    {
        return $this->join("message")->on("message.conversation_id","=","conversation.id")->where(["conversation.status","=",RUNNING_CHAT])->or_where(["listener_id","=",$id],["user_id","=",$id])->row_count();
    }
    public function is_listener($id)
    {
        return $this->where(["conversation.status","=",RUNNING_CHAT],["listener_id","=",$id])->is_exist();
    }
}