<?php
namespace lib\vendor;
trait data_file_storage
{
    private $storage = [];
    protected function regiester_file($file_name,$path)
    {
        $file_data = include_once $path . '.php' ;
        $this->set_data($file_name,$file_data);
        return $this->get_data($file_name);
    }
    protected function set_data($key,$data)
    {
        if(!$this->data_exist($key)) $this->storage[$key] = $data;
    }
    protected function get_data($key)
    {
        return $this->storage[$key];
    }
    protected function get_storage()
    {
        return $this->storage;
    }
    protected function is_file_included($path)
    {
        return in_array($path.'.php',get_included_files());
    }
    private function data_exist($key)
    {
        return isset($this->storage[$key]);
    }
}