<?php
namespace models;
class problem_content extends model
{
    protected static $table_name = 'problem_content';
    public static $table_schema = array(
        'id'                => '',
        'problem_id'        => '',
        'message_content'   => '',
        'msg_from'          => '',
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