<?php
namespace app\core;

class View{
    public $path;
    public $route;
    public $layout = 'default';
    
    public function __construct($route){
        $this->route = $route;
        $this->path = $this->route['controller'].'/'.$this->route['action'];
    }
    public function render($title, $vars = []){
        if (file_exists('app/views/'.$this->path.'.php')){
            extract($vars);
            ob_start();
            require 'app/views/'.$this->path.'.php';
            $content = ob_get_clean();
            require 'app/views/layout/'.$this->layout.'.php';
        }
    }

    public static function errorCode($code){
        http_response_code($code);
        if (file_exists('app/views/errors/'.$code.'.php')){
            require 'app/views/errors/'.$code.'.php';
            exit;
        }
    }

    public function redirect($url){
        header('location: '.$url);
        exit;
    }
}