<?php
namespace lib\vendor;
trait helper
{
    use data_file_storage,cookies_maker,message;
    private function redirect($path = null)
    {
        session_write_close();
        $finalURL = (empty($path) && isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $path;
        header('Location: ' . $finalURL);
        exit();
    }
    private function generate_random_string($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    private function redirect_with_message($message,$type = "",$path = null)
    {
        $this->set_message($message,$type);
        $finalURL = (empty($path) && isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : $path;
        header('Location: ' . $finalURL);
        session_write_close();
        exit();
    }
    protected function __($path)
    {
        $lang = LANG_PATH.DEFAULT_LANG;
        if($this->cookie_exist('lang') && $this->is_cookie_not_empty('lang') && is_dir(LANG_PATH.$this->take_a_cookie('lang')))
            $lang = LANG_PATH.$this->take_a_cookie('lang');

        $path = str_replace('.',DS,$path);

        return $this->handle_file($lang.DS.$path);
    }
    private function hash($pass)
    {
        return sha1(md5($pass).HARD_HASH);
    }
    private function handle_file($path)
    {
        $arr_path = explode(DS,$path);
        $target = $arr_path[count($arr_path)-1];
        $file_name = $arr_path[count($arr_path)-2];
        unset($arr_path[count($arr_path)-1]);
        $path = implode(DS,$arr_path);
        if($this->is_file_included($path)){
            return $this->get_data($file_name)[$target];
        }else{
            return $this->load_file($path,$file_name,$target);
        }
    }
    private function load_file($path,$file_name,$target)
    {
        if(file_exists($path.'.php')){
            $file_data = $this->regiester_file($file_name,$path);
            return $file_data[$target];
        }else{
            return $target;
        }
    }
}