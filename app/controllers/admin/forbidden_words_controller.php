<?php
namespace controllers\admin;
use lib\vendor\sessionmanger;
use lib\vendor\requests;
use lib\vendor\helper;
use lib\vendor\token;
use lib\vendor\message;
use lib\vendor\class_factory;
use controllers\controller as controller;
class forbidden_words_controller extends controller
{
    use sessionmanger,requests,helper,token,message;
    protected $active_page = "forbidden_words";
    protected $words = "";
    private $file_name = STORAGE_PATH . 'forbidden_words.txt';
    private $params;
    public function __construct()
    {
        if($this->current_user() !== ADMIN || $this->get_session("id") != OWNER_ID){
            $this->redirect('/admin');
        }
    }
    public function default_action()
    {
        $this->get_bad_words_file();
        $this->loadHeader(ADMIN_TEMP);
        $this->renderNav(ADMIN_TEMP);
        $this->_view(ADMIN_VIEWS."bad_words");
        $this->loadFooter(ADMIN_TEMP);
    }
    private function get_bad_words_file()
    {
        $fh = fopen($this->file_name,'r');
        while ($line = fgets($fh)) {
            $this->words .= $line;
        }
        fclose($fh);
    }
    public function update_action()
    {
        $this->post("update");
    }
    private function update($params)
    {
        $this->set_params($params)->is_auth()->store_data()->redirect_with_message("تم التحديث بنجاح","success");
    }
    private function set_params($params)
    {
        $this->params = $params;
        return $this;
    }
    private function is_auth()
    {
        return $this->check_token($this->params) ? $this : $this->redirect_with_message("هناك شئ ما خطأ","danger","/admin");
    }
    private function store_data()
    {
        file_put_contents($this->file_name, $this->params['bad_words'].PHP_EOL , LOCK_EX);
        return $this;
    }
}