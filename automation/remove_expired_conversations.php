<?php
namespace automation;
require "init_automation.php";
require_once CONFIG_AUTO.'chat.php';
use lib\vendor\class_factory;
class remove_expired_conversations{
    private $conversation_model;
    public function __construct() {
        $this->set_conversation_model()->remove_expired_chat();
    }
    private function set_conversation_model()
    {
        $this->conversation_model = class_factory::create_instance("models\conversation");
        return $this;
    }
    private function remove_expired_chat()
    {
        $this->conversation_model->where(["status","=",DISABLE_CHAT],["TIMESTAMPDIFF(MONTH , deleted_at,NOW())",">=",1])->delete();
        exit();
    }
}
new remove_expired_conversations;