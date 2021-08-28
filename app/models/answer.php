<?php
namespace models;
class answer extends model
{
    protected static $table_name = 'answer';
    public static $table_schema = array(
        'id'                => '',
        'question_id'       => '',
        'answer_content'    => '',
        'is_right'          => ''
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