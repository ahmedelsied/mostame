<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\requests;
use lib\vendor\helper;
use lib\vendor\load_component;
use lib\vendor\token;
use lib\vendor\validator;
use lib\vendor\message;
use lib\vendor\class_factory;
use controllers\controller as controller;
class supervisors_controller extends controller
{
    use sessionmanger,requests,helper,load_component,token,validator,message;
    protected $active_page = "supervisors";
    protected $supervisor_info;
    protected $supervisors;
    private $isset_password;
    private $params;
    public function __construct()
    {
        if($this->current_user() !== ADMIN || $this->get_session("id") != OWNER_ID){
            $this->redirect('/admin');
        }
        $this->supervisor_model = class_factory::create_instance("models\admin");
    }
    public function default_action()
    {
        $this->supervisors = $this->supervisor_model->where("id",$this->get_session("id"),"!=")->order_by("id")->order("DESC")->get("id,full_name,user_name,created_at")->data;
        $this->render_app("supervisors");
    }
    public function add_action()
    {
        $this->render_app("add_supervisors");
    }
    public function create_action()
    {
        $this->post("create");
    }
    private function create($params)
    {
        $this->set_params($params)->is_auth()->is_exist_user_name()->validate_create_data()->create_supervisor()->redirect_with_message("تمت الإضافه بنجاح","success");
    }
    private function validate_create_data()
    {
        return ($this->max($this->params['full_name'],50) && $this->max($this->params['user_name'],30) && !empty($this->params['password']) && !empty($this->params['cnfrm-pass']) && $this->params['password'] == $this->params['cnfrm-pass']) ? $this : $this->not_auth("من فضلك قم بكتابة البيانات بشكل صحيح");
    }
    private function is_exist_user_name()
    {
        return !($this->supervisor_model->where("user_name",$this->params['user_name'])->is_exist()) ? $this : $this->not_auth("اسم المستخدم موجود من قبل");
    }
    private function create_supervisor()
    {
        $this->supervisor_model->full_name = $this->params['full_name'];
        $this->supervisor_model->user_name = $this->params['user_name'];
        $this->supervisor_model->password  = $this->hash($this->params['password']);
        $this->supervisor_model->save();
        return $this;
    }
    public function edit_action($params)
    {
        $this->supervisor_info = $this->supervisor_model->where("id",$params[0])->get("id,full_name,user_name")->data[0];
        $this->render_app("edit_supervisors");
    }
    public function update_action()
    {
        $this->post("update");
    }
    private function update($params)
    {
        $this->set_params($params)->is_auth()->validate_update_data()->check_for_password()->update_supervisor()->redirect_with_message("تم التعديل بنجاح","success");
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
    private function validate_update_data()
    {
        return ($this->max($this->params['full_name'],50) && $this->max($this->params['user_name'],30)) ? $this : $this->not_auth("من فضلك قم بكتابة البيانات بشكل صحيح");
    }
    private function check_for_password()
    {
        $this->isset_password = (isset($this->params['password']) && isset($this->params['cnfrm-pass']) && !empty($this->params['password']) && !empty($this->params['cnfrm-pass']));
        return $this->isset_password ? $this->match_passwords() : $this;
    }
    private function match_passwords()
    {
        if($this->isset_password){
            return $this->params['password'] == $this->params['cnfrm-pass'] ? $this->set_password() : $this->not_auth("كلمتا السر غير متطابقتان");
        }
        return $this;
    }
    private function set_password()
    {
        $this->password = $this->hash($this->params['password']);
        return $this;
    }
    private function update_supervisor()
    {
        $this->supervisor_model->full_name = $this->params['full_name'];
        $this->supervisor_model->user_name = $this->params['user_name'];
        if(!empty($this->password)){
            $this->supervisor_model->password = $this->password;
        }
        $this->supervisor_model->where("id",$this->params['supervisor_id'])->save();
        return $this;
    }
    public function remove_action($id)
    {
        $id = $id[0];
        $this->supervisor_model->where("id",$id)->delete();
        $this->redirect_with_message("تم الحذف بنجاح","success","/admin/supervisors");
    }
    private function not_auth($msg)
    {
        $this->redirect_with_message($msg,"danger");
    }
    private function render_app($view)
    {
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.$view);
        $this->loadFooter(ADMIN_TEMP);
    }
}