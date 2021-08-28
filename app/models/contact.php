<?php
namespace models;
class contact extends model
{
    protected static $table_name = 'contact';
    public static $table_schema = array(
        'id'        => '',
        'full_name' => '',
        'email'     => '',
        'subject'   => '',
        'msg'       => '',
        'send_at'   => ''
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