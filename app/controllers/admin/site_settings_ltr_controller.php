<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\requests;
use lib\vendor\message;
use lib\vendor\input_filter;
use lib\vendor\load_component;
use lib\vendor\class_factory;
use controllers\controller as controller;
class site_settings_ltr_controller extends controller
{
    use sessionmanger,helper,token,requests,message,input_filter,load_component;
    protected $active_page = "site_settings_ltr";
    protected $main_page;
    protected $about_us;
    protected $terms;
    protected $end_chat;
    private $params;
    private $data;
    private $site_settings_model;
    public function __construct()
    {
        if($this->current_user() !== ADMIN){
            $this->redirect('/admin');
        }
        $this->site_settings_model = class_factory::create_instance("models\site_settings_ltr");
    }
    public function default_action()
    {
        $this->data = $this->site_settings_model->get()->data;
        $this->init_data();
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS.'site_settings_ltr');
        $this->loadFooter(ADMIN_TEMP);
    }
    private function init_data()
    {
        $this->set_main_page_text()->set_about_us_text()->set_terms_text()->set_end_chat_text();
    }
    private function set_main_page_text()
    {
        $this->main_page = $this->data[0]['content'];
        return $this;
    }
    private function set_about_us_text()
    {
        $this->about_us = $this->data[1]['content'];
        return $this;
    }
    private function set_terms_text()
    {
        $this->terms = $this->data[2]['content'];
        return $this;
    }
    private function set_end_chat_text()
    {
        $this->end_chat = $this->data[3]['content'];
        return $this;
    }
    public function update_action()
    {
        $this->post("update");
    }
    private function update($params)
    {
        $this->set_params($params)->is_auth()->valid_data()->save()->redirect_with_message("تم التعديل بنجاح","success","/admin/site_settings_ltr");
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
    private function valid_data()
    {
        return (isset($this->params['end_chat']) && isset($this->params['main_page']) && isset($this->params['about_us']) && isset($this->params['terms'])) ? $this : $this->not_auth("هناك مشكله ما");
    }
    private function save()
    {
        $col = "";
        
        if(!empty($this->params['main_page'])){
            $col .= "WHEN ".(MAIN_PAGE_TEXT-1)." THEN '".$this->filter_string($this->params['main_page'])."' ";
        }
        if(!empty($this->params['about_us'])){
            $col .= "WHEN ".(ABOUT_US_TEXT-1)." THEN '".$this->filter_string($this->params['about_us'])."' ";
        }
        if(!empty($this->params['terms'])){
            $col .= "WHEN ".(TERMS-1)." THEN '".$this->filter_string($this->params['terms'])."' ";
        }
        if(!empty($this->params['end_chat'])){
            $col .= "WHEN ".(END_OF_CHAT_TEXT-1)." THEN '".$this->filter_string($this->params['end_chat'])."' ";
        }
        $sql = "UPDATE site_settings_ltr
        SET content = CASE id 
            $col
            ELSE content
            END";
        $this->site_settings_model->execute_multi($sql);
        return $this;
    }
    private function not_auth($msg)
    {
        $this->redirect_with_message($msg,"danger","/");
    }
}