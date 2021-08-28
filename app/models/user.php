<?php
namespace models;
class user extends model
{
    protected static $table_name = 'user';
    public static $table_schema = array(
        'id'        => '',
        'full_name' => '',
        'email'     => '',
        'type'      => '',
        'password'  => '',
        'gender'    => '',
        'birthdate' => '',
        'city'      => '',
        'status'    => '',
        'user_from' => '',
        'banned'    => '',
        'available' => '',
        'joined_at' => '',
        'banned_to' => ''
    );
    protected static $primary_key = 'id';
    private function user_status($id)
    {
        $user_status = $this->where("id",$id)->get("status")->pluck("status");
        return $user_status;
    }
    public function is_not_active($id)
    {
        return $this->user_status($id) == DISABLE_USER;
    }
    public function is_active($id)
    {
        return $this->user_status($id) == ACTIVE_USER;
    }
    public function is_have_listener_question($id)
    {
        return $this->where(["id","=",$id],["status","=",LISTENER_QUESTION])->is_exist();
    }
    public function is_banned($id)
    {
        return $this->where(["id","=",$id],["banned","=",1])->is_exist();
    }
    public function load_more($id,$offset,$limit)
    {
        return $this->where(["id","!=",$id],["available","=",IN_QUEUE])->offset($offset)->limit($limit)->get();
    }
    public function __set($prop,$value)
    {
        self::$table_schema[$prop] = $value;
    }
    public function __get($prop)
    {
        return self::$table_schema[$prop];
    }
}