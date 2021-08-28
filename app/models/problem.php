<?php
namespace models;
class problem extends model
{
    protected static $table_name = 'problem';
    public static $table_schema = array(
        'id'                => '',
        'user_id'           => '',
        'conversation_id'   => '',
        'status'            => '',
        'created_at'        => '',
        'closed_at'         => ''
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