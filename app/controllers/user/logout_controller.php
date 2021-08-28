<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use controllers\controller as controller;
class logout_controller extends controller
{
    use sessionmanger,helper;
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect("/");
        }
    }
    public function default_action()
    {
        $this->finish_session();
        $this->redirect("/");
    }
}