<?php
namespace lib\vendor;
trait load_component
{
    private $component;
    public function fire_component(string $component_name) : void
    {
        $this->set_component($component_name);
        if($this->component_exist()) include $this->component;
    }
    private function set_component(string $component_name) : void
    {
        $user = $this->get_session('logged') == "listener" ? "user" : $this->get_session('logged');
        $this->component = __DIR__.DS."..".DS."..".DS.VIEWS.$user.DS."components".DS.$component_name.".php";
    }
    private function component_exist() : bool
    {
        return file_exists($this->component);
    }
}