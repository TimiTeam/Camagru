<?php

namespace app\core;

use app\core\View;

class Router {

    protected $routs = [];
    protected $params = [];

    function __construct(){
        $arr = require'app/config/routes.php';
        foreach ($arr as $key => $val)
            $this->add($key, $val); 
    }
    public function add($route, $params){
        $route = '#^'.$route.'$#';
        $this->routs[$route] = $params;
    }

    public function match(){
        $pth = explode('?', $_SERVER['REQUEST_URI']);
        $url = trim($pth[0],'/');
        $url = str_replace('?', '', $url);
        foreach ($this->routs as $route => $params){
            if (preg_match($route, $url, $matches)){
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    public function run(){
        if ($this->match()){
            $path = 'app\controllers\\'.ucfirst($this->params['controller'].'Controller');
            if (class_exists($path)){
                $action = $this->params['action'].'Action';
                
                if (method_exists($path, $action)){
                    $controller = new $path($this->params);
                    $controller->$action();
                }
                else{
                    View::errorCode(404);
                }
            }
            else {
                    View::errorCode(404);
            }
        }
        else
            View::errorCode(404);
    }
}