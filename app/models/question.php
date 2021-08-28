<?php
namespace models;
class question extends model
{
    protected static $table_name = 'question';
    public static $table_schema = array(
        'id'                => '',
        'question_content'  => '',
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
    public function get_current_question_id($offset)
    {
        return $this->offset($offset)->limit(1)->get("id")->pluck("id");
    }
}