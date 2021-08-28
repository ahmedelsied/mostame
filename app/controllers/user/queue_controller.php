<?php
namespace controllers\user;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\load_component;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\validator;
use lib\vendor\class_factory;
use controllers\controller as controller;
class queue_controller extends controller
{
    use sessionmanger,helper,load_component,token,requests,validator;
    protected $active_page = 'queue';
    protected $queue;
    private $user_model;
    private $params;
    public function __construct()
    {
        if(!in_array($this->current_user(),[LISTENER,USER,BOTH])){
            $this->redirect("/");
        }
        $this->user_model = class_factory::create_instance('models\user');

        if($this->user_model->is_banned($this->get_session("id"))){
            $this->redirect("/user/logout");
        }

        $authorized = $this->user_model->is_active($this->get_session("id"));

        if(!$authorized){
            $this->redirect("/user");
        }
    }
    public function default_action()
    {
        $this->queue = $this->user_model->where(["id","!=",$this->get_session("id")],["available","=",IN_QUEUE])->limit(SERVER_LIMIT)->get()->data;
        $this->loadHeader(USER_TEMP);
        $this->renderNav(USER_TEMP);
        $this->_view(USER_VIEWS.'queue');
        $this->loadFooter(USER_TEMP);
    }
    public function load_more_users_action()
    {
        $this->ajax("load_more_users");
    }
    private function load_more_users($params)
    {
        $this->params = $params;
        $this->is_auth_to_load_more()->check_params_exist()->load_more()->sent_data();
    }
    private function is_auth_to_load_more()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth();
    }
    private function check_params_exist()
    {
        return (isset($this->params['offset']) && isset($this->params['limit']) && $this->int($this->params['offset']) && $this->int($this->params['limit'])) ? $this : $this->not_auth();
    }
    private function load_more()
    {
        $this->data = $this->user_model->load_more($this->get_session("id"),$this->params['offset'],$this->params['limit']);
        return $this;
    }
    private function sent_data()
    {
        echo json_encode($this->data);
        exit();
    }
    private function not_auth()
    {
        echo "error";
        exit();
    }
}