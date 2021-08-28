<?php
namespace myApp;
class parameters_checker
{
    protected function parameters_checker(array $parameters,array $data) : bool
    {
        foreach($parameters as $parameter){
            if(!isset($data[$parameter]) || empty($data[$parameter])) return false;
        }
        return true;
    }
}