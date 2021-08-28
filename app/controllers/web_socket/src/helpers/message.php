<?php
namespace MyApp\helpers;
trait message
{
    private $data;
    private $instance;
    private function message($type,$data)
    {
        $this->set_data($data);
        $this->type = $type;
        if($this->check_for_target()){
            $this->instance = $this->type."\\".$this->data['target'];
            return true;
        }
        return false;
    }
    private function check_for_target()
    {
        if(isset($this->data['target']) && $this->is_valid_target()) return true;
        return false;
    }
    private function is_valid_target()
    {
        $path = __DIR__.DS."..".DS.$this->type.DS.$this->data['target'].".php";
        if(file_exists($path)){
            return true;
        }
        return false;
    }
    private function set_data($data)
    {
        $this->data = json_decode($data,true);
    }
}