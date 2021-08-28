<?php
namespace controllers\main;
use controllers\controller;
use lib\vendor\helper;
use lib\vendor\sessionmanger;
use lib\vendor\cookies_maker;
use lib\vendor\class_factory;
class terms_controller extends controller
{
    use helper,sessionmanger,cookies_maker;
    protected $active_page = '';
    public function __construct()
    {
        if($this->current_user() != null){
            $this->redirect(DOMAIN.'/'.$this->get_session('logged'));
        }
        $settings = "";
        $this->setting_index = 0;
        if($this->__('settings.align') == "left"){
            $settings = "_ltr";
            $this->setting_index = 1;
        }
        $this->site_settings = class_factory::create_instance("models\site_settings".$settings);
    }
    public function default_action()
    {
        $this->terms_text = $this->site_settings->where("id",(TERMS-$this->setting_index))->get("content")->pluck("content");
        $this->terms_text = str_replace("\n", '<br>', $this->terms_text);
        $this->loadHeader(MAIN_TEMP);
        $this->renderNav(MAIN_TEMP);
        $this->_view(MAIN_VIEWS.'terms');
        $this->loadFooter(MAIN_TEMP);
    }
}