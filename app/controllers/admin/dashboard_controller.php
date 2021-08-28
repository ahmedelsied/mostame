<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class dashboard_controller extends controller
{
    use sessionmanger,helper,load_component;
    protected $active_page = "dashboard";
    protected $banned_users;
    protected $users_curve;
    protected $latest_users;
    private $user_model;
    private $chat_model;
    private $problem_model;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->user_model = class_factory::create_instance("models\user");
        $this->chat_model = class_factory::create_instance("models\conversation");
        $this->problem_model = class_factory::create_instance("models\problem");
    }
    public function default_action()
    {
        $this->init_page_data();
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.'dashboard');
        $this->loadFooter(ADMIN_TEMP);
    }
    private function init_page_data()
    {
        $this->statistics();
        $this->user_curve();
        $this->latest_users();
    }
    private function statistics()
    {
        $this->banned_users = $this->user_model->where("banned",true)->row_count();
        $this->total_problems = $this->problem_model->row_count();
        $this->opened_chat = $this->chat_model->where("status",RUNNING_CHAT)->row_count();
        $this->total_users = $this->user_model->row_count();
    }
    private function user_curve()
    {
        $this->users_curve = $this->user_model->group_by("joined_at")->get("COUNT(id) as count,joined_at")->data;
    }
    private function latest_users()
    {
        $this->latest_users = $this->user_model->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
    }
    protected function gender($gender)
    {
        if(!empty($gender) || $gender == MALE){
            if($gender == FEMALE) return "أنثى";
            else return $gender == MALE ? "ذكر" : "جنس آخر";
        }
        return "";
    }
    protected function type($type)
    {
        return USERS_PERMISSION[$type];
    }
    protected function pad($string)
    {
        return str_pad($string,5,'0',STR_PAD_LEFT);
    }
}