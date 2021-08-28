<?php
namespace automation;
require "init_automation.php";
require_once CONFIG_AUTO.'code.php';
use lib\vendor\class_factory;
class remove_expired_code{
    private $problem_model;
    public function __construct() {
        $this->set_code_model()->remove_expired_code();
    }
    private function set_code_model()
    {
        $this->problem_model = class_factory::create_instance("models\code");
        return $this;
    }
    private function remove_expired_code()
    {
        $this->problem_model->where(["status","=",EXPIRED])->delete();
        exit();
    }
}
new remove_expired_code;