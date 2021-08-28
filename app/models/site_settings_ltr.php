<?php
namespace models;
class site_settings_ltr extends model
{
    protected static $table_name = 'site_settings_ltr';
    public static $table_schema = array(
        'id'        => '',
        'content'   => '',
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