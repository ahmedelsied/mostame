<?php
namespace models;
class code extends model
{
    protected static $table_name = 'code';
    public static $table_schema = array(
        'id'        => '',
        'code'      => '',
        'user_id'   => '',
        'status'    => '',
        'expire_at' => ''
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
    public function to_expired_code($user_id)
    {
        if(!empty($this->where(["code","=",$this->code],["user_id","=",$user_id],["status","=",ACTIVE])->get('code')->pluck('code'))){
            $this->status = 1;
            $this->where("code",$this->code)->save();
            return true;
        }else{
            return false;
        }
    }
}