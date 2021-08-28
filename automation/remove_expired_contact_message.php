<?php
namespace automation;
require "init_automation.php";
use lib\vendor\class_factory;
class remove_expired_contact_message{
    private $contact_model;
    public function __construct() {
        $this->set_contact_model()->remove_expired();
    }
    private function set_contact_model()
    {
        $this->contact_model = class_factory::create_instance("models\contact");
        return $this;
    }
    private function remove_expired()
    {
        $this->contact_model->where(["is_reply","=",true],["TIMESTAMPDIFF(MONTH , send_at,NOW())",">=",1])->delete();
        exit();
    }
}
new remove_expired_contact_message;