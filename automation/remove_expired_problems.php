<?php
namespace automation;
require "init_automation.php";
require_once CONFIG_AUTO.'problems.php';
use lib\vendor\class_factory;
class remove_expired_problems{
    private $problem_model;
    public function __construct() {
        $this->set_problem_model()->remove_expired_chat();
    }
    private function set_problem_model()
    {
        $this->problem_model = class_factory::create_instance("models\problem");
        return $this;
    }
    private function remove_expired_chat()
    {
        $this->problem_model->where(["status","=",CLOSED],["TIMESTAMPDIFF(MONTH , closed_at,NOW())",">=",1])->delete();
        exit();
    }
}
new remove_expired_problems;