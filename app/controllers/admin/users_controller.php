<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\message;
use lib\vendor\validator;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class users_controller extends controller
{
    use sessionmanger,helper,message,validator,token,requests,load_component;
    protected $active_page = "users";
    protected $users;
    private $user_model;
    private $password;
    private $data;
    private $params;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->user_model = class_factory::create_instance("models\user");
    }
    public function default_action()
    {
        $this->users = $this->user_model->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        $this->set_session("load_more",SERVER_LIMIT);
        $this->render_app('users');
    }
    public function load_more_action()
    {
        $this->ajax("load_more");
    }
    private function load_more($params)
    {
        $this->set_params($params)->is_auth()->valid_load_more_type()->get_load_more_data()->set_new_offset()->sent_data();
    }
    private function valid_load_more_type()
    {
        return isset($this->params['type']) ? $this : exit();
    }
    private function check_type()
    {
        if($this->get_session("type") != $this->params['type']){
            $this->set_session("type",$this->params['type']);
            $this->set_session("load_more",0);
        }
    }
    public function find_user_action()
    {
        $this->ajax("find_user");
    }
    private function find_user($params)
    {
        $this->set_params($params)->is_auth()->valid_id()->get_user()->sent_data();
    }
    private function valid_id()
    {
        return (isset($this->params['id']) && $this->num($this->params['id'])) ? $this : exit();
    }
    private function get_user()
    {
        $this->data = $this->user_model->where("id",$this->params["id"])->get()->data;
        return $this;
    }
    private function get_load_more_data()
    {
        if(isset($this->params['first_time'])){
            $this->set_session("load_more",0);
        }
        if(empty($this->params['type'])){
            $this->data = $this->user_model->offset($this->get_session("load_more"))->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        }elseif($this->params['type'] == "banned"){
            $this->check_type();
            $this->data = $this->user_model->where("banned",true)->offset($this->get_session("load_more"))->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        }else{
            $this->check_type();
            $this->data = $this->user_model->where("type",$this->params['type'])->offset($this->get_session("load_more"))->limit(SERVER_LIMIT)->order_by("id")->order("DESC")->get()->data;
        }
        return $this;
    }
    private function set_new_offset()
    {
        $new_offset = $this->get_session("load_more")+SERVER_LIMIT;
        $this->set_session("load_more",$new_offset);
        return $this;
    }
    private function sent_data()
    {
        echo json_encode($this->data,JSON_UNESCAPED_SLASHES);
        exit();
    }
    public function add_action()
    {
        $this->render_app('add_users');
    }
    public function edit_action($params)
    {
        $this->user_data = $this->user_model->where("id",$params[0])->get()->data[0];
        $this->is_native_user = $this->user_data['user_from'] == null;
        $this->set_session("is_native_user",$this->is_native_user);
        $this->render_app('edit_users');
    }
    public function update_action()
    {
        $this->post("update");
    }
    private function update($params)
    {
        $this->set_params($params)->is_auth()->validate_update()->update_user()->redirect_with_message("تم التعديل بنجاح","success");
    }
    private function validate_update()
    {
        if($this->get_session("is_native_user")){
            $this->valid_user_id()->valid_full_name()->valid_update_email()->valid_city()->valid_gender()->valid_birthdate()->valid_type()->valid_update_password();
        }else{
            $this->valid_user_id()->valid_full_name()->valid_type();
        }
        return $this;
    }
    private function update_user()
    {
        if($this->get_session("is_native_user")){
            $this->user_model->full_name = $this->params['full_name'];
            $this->user_model->email = $this->params['email'];
            if(!empty($this->password)) $this->user_model->password = $this->password;
            $this->user_model->city = $this->params['city'];
            $this->user_model->gender = $this->params['gender'];
            $this->user_model->birthdate = $this->params['birthdate'];
            $this->user_model->type = $this->params['user-type'];
            $this->user_model->where("id",$this->params["user_id"])->save();
        }else{
            $this->user_model->full_name = $this->params['full_name'];
            $this->user_model->type = $this->params['user-type'];
            $this->user_model->where("id",$this->params["user_id"])->save();
        }
        return $this;
    }
    private function valid_user_id()
    {
        return (isset($this->params['user_id']) && (!empty($this->params['user_id']))) ? $this : $this->not_auth("هناك شئ ما خطأ");
    }
    private function valid_update_password()
    {
        return (isset($this->params['password']) && isset($this->params['cnfrm-pass']) && !empty($this->params['password']) && !empty($this->params['cnfrm-pass'])) ? $this->check_update_match_password() : null;
    }
    private function check_update_match_password()
    {
        return $this->params['password'] == $this->params['cnfrm-pass'] ? $this->set_password() : null;
    }
    private function valid_update_email()
    {
        return (isset($this->params['email']) && !empty($this->params['email']) && !($this->user_model->where(["email","=",$this->params['email']],["id","!=",$this->params["user_id"]])->is_exist()) && $this->max($this->params['email'],50)) ? $this : $this->not_auth("يبدو أن هناك مشكله في البريد الإلكتروني أو أنه موجود بالفعل");
    }
    public function create_action()
    {
        $this->post("create");
    }
    private function create($params)
    {
        $this->set_params($params)->is_auth()->validate_create()->add_user()->redirect_with_message("تم الإضافه بنجاح","success");
    }
    private function validate_create()
    {
        $this->valid_full_name()->valid_email()->valid_city()->valid_gender()->valid_birthdate()->valid_type()->valid_password();
        return $this;
    }
    private function add_user()
    {
        $this->user_model->full_name = $this->params['full_name'];
        $this->user_model->email = $this->params['email'];
        $this->user_model->password = $this->password;
        $this->user_model->city = $this->params['city'];
        $this->user_model->gender = $this->params['gender'];
        $this->user_model->birthdate = $this->params['birthdate'];
        $this->user_model->type = $this->params['user-type'];
        $this->user_model->status = ACTIVE_USER;
        $this->user_model->save();
        return $this;
    }
    private function valid_full_name()
    {
        return (isset($this->params['full_name']) && !empty($this->params['full_name']) && $this->max($this->params['full_name'],50)) ? $this : $this->not_auth("يرجى كتابة الاسم بالكامل  بشكل صحيح");
    }
    private function valid_email()
    {
        return (isset($this->params['email']) && !empty($this->params['email']) && !($this->user_model->where("email",$this->params['email'])->is_exist()) && $this->max($this->params['email'],50)) ? $this : $this->not_auth("يبدو أن هناك مشكله في البريد الإلكتروني أو أنه موجود بالفعل");
    }
    private function valid_city()
    {
        return (isset($this->params['city']) && !empty($this->params['city']) && $this->max($this->params['city'],20)) ? $this : $this->not_auth("يرجى كتابة اسم المدينه بشكل صحيح");
    }
    private function valid_gender()
    {
        return (isset($this->params['gender']) && (!empty($this->params['gender']) || $this->params['gender'] == MALE) && $this->between($this->params['gender'],MALE-1,OTHER+1)) ? $this : $this->not_auth("يرجى اختيار الجنس من القائمه");
    }
    private function valid_birthdate()
    {
        return (isset($this->params['birthdate']) && !empty($this->params['birthdate']) && $this->vdate($this->params['birthdate'])) ? $this : $this->not_auth("يرجى كتابة إدخال تاريخ الميلاد بطريقه صحيحه");
    }
    private function valid_type()
    {
        return (isset($this->params["user-type"]) && !empty($this->params['user-type']) && isset(USERS_PERMISSION[$this->params['user-type']])) ? $this : $this->not_auth("يرجى تحديد الصلاحيه");
    }
    private function valid_password()
    {
        return (isset($this->params['password']) && isset($this->params['cnfrm-pass']) && !empty($this->params['password']) && !empty($this->params['cnfrm-pass'])) ? $this->check_match_password() : $this->not_auth("يرجى إدخال كلمة السر");
    }
    private function check_match_password()
    {
        return $this->params['password'] == $this->params['cnfrm-pass'] ? $this->set_password() : $this->not_auth("يرجى كتابة كلمتا السر غير متطابقتان");
    }
    private function set_password()
    {
        $this->password = $this->hash($this->params['password']);
    }
    public function remove_action($id)
    {
        $id = $id[0];
        $this->user_model->where("id",$id)->delete();
        $this->redirect_with_message("تم الحذف بنجاح","success","/admin/users/");
    }
    public function ban_action($id)
    {
        $id = $id[0];
        $this->user_model->banned = true;
        $this->user_model->where("id",$id)->save();
        $this->redirect_with_message("تم التحديث بنجاح","success","/admin/users");
    }
    public function unban_action($id)
    {
        $id = $id[0];
        $this->user_model->banned = 0;
        $this->user_model->where("id",$id)->save();
        $this->redirect_with_message("تم التحديث بنجاح","success","/admin/users/");
    }
    private function set_params($params)
    {
        $this->params = $params;
        return $this;
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->not_auth("هناك شئ ما خطأ");
    }
    private function not_auth($msg)
    {
        $this->redirect_with_message($msg,"danger","/");
    }
    protected function gender($gender)
    {
        if(!empty($gender) || $gender == MALE){
            if($gender == FEMALE) return "أنثى";
            else return $gender == MALE ? "ذكر" : "جنس آخر";
        }
        return "";
    }
    protected function gender_selected($gender,$selected)
    {
        return $gender == $selected ? "selected" : "";
    }
    protected function type($type)
    {
        return USERS_PERMISSION[$type];
    }
    private function render_app($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
}