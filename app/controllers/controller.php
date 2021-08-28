<?php
namespace controllers;
use lib\vendor\front_controller;
class controller
{
    protected function active_link()
    {
        $this->url = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'), 3);
    }
    protected function is_active_page($page)
    {
        return $this->active_page == $page ? "class='active'" : "";
    }
    protected function loadHeader($type)
    {
        $this->loadTemp($type.'templateHeader');
    }
    protected function renderNav($type)
    {
        $this->loadTemp($type.'nav');
    }
    protected function loadFooter($type,$var_footer = null)
    {
        $this->loadTemp($type.'appFooter');
        if($var_footer == true){
            $this->loadTemp($type.'var_footer');
        }
        $this->loadTemp($type.'templateFooter');
    }
    public function _view($view)
    {
        $view = str_replace('.',DS,$view);
        require_once APP_PATH . $view . '_view.php';
    }
    public function setParams($params,$count)
    {
        if(count($params) == $count){
            return [true,count($params)];
        }else{
            return false;
        }
    }
    public function invalid_params_action()
    {
        http_response_code(422);
        exit();
    }
    public function not_found_action()
    {
        $instance = new \controllers\erros\not_found;
        $instance->not_found_action();
        exit();
    }
    private function loadTemp($temp)
    {
        require_once APP_PATH . $temp.'.php';
    }
}