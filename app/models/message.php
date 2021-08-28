<?php
namespace models;
class message extends model
{
    protected static $table_name = 'message';
    public static $table_schema = array(
        'id'                => '',
        'conversation_id'   => '',
        'sender_id'         => '',
        'message_content'   => '',
        'send_at'           => ''
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
}