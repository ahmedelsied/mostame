<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use controllers\controller as controller;
class logout_controller extends controller
{
    use sessionmanger,helper;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect("/");
        }
    }
    public function default_action()
    {
        $this->finish_session();
        $this->redirect("/admin");
    }
}