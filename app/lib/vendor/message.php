<?php
namespace lib\vendor;
trait message{
    protected function set_message($value,$type)
    {
        $this->set_session("message",$value);
        $this->set_session("message-type",$type);
    }
    protected function msg_data()
    {
        return $this->get_session("message");
    }
    protected function get_message()
    {
        if(empty($this->msg_data())) return;
        if(gettype($this->msg_data()) == "array"){
            echo "<ul class='".$this->get_session("message-type")."-backend-message backend-message list-unstyled'>";
            foreach($this->msg_data() as $msg){
                echo "<li>".$msg."</li>";
            }
            echo "</ul>";
        }else{
            echo "<div class='".$this->get_session("message-type")."-backend-message backend-message'>".$this->msg_data()."</div>";
        }
        $this->unset_session("message");
    }
    protected function x_http_msg($msg,$type)
    {
        if(gettype($msg) == "array"){
            echo "<ul class='".$type."-backend-message backend-message list-unstyled'>";
            foreach($msg as $m){
                echo "<li>".$m."</li>";
            }
            echo "</ul>";
        }else{
            echo "<div class='".$type."-backend-message backend-message'>".$msg."</div>";
        }
        exit();
    }
}